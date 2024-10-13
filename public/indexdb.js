
let db;
const request = indexedDB.open("EventReminderDB", 1);

request.onupgradeneeded = function(event) {
    db = event.target.result;

    // Create an object store for events
    const objectStore = db.createObjectStore("events", {
        keyPath: "id",
        autoIncrement: true
    });
    objectStore.createIndex("eventId", "eventId", { unique: true });
};

request.onsuccess = function(event) {
    db = event.target.result;
    console.log("IndexedDB initialized");

    // Sync offline data if online
    if (navigator.onLine) {
        syncOfflineData();
    }
};

request.onerror = function(event) {
    console.error("Database error:", event.target.error);
};

// Add event to IndexedDB
function addEventOffline(event) {
    const transaction = db.transaction(["events"], "readwrite");
    const objectStore = transaction.objectStore("events");
    objectStore.add(event);
    console.log("Event added to offline store:", event);
}

// Sync offline data to server
function syncOfflineData() {
    console.log("Attempting to sync offline events...");
    const transaction = db.transaction(["events"], "readonly");
    const objectStore = transaction.objectStore("events");
    const request = objectStore.getAll();

    request.onsuccess = function(event) {
        const offlineEvents = event.target.result;
        if (offlineEvents.length > 0) {
            offlineEvents.forEach(event => syncWithServer(event));
            console.log("Synced all offline events to server.");
        } else {
            console.log("No offline events to sync.");
        }
    };

    request.onerror = function() {
        console.error("Failed to read offline events.");
    };
}

function syncWithServer(event) {
    fetch('/api/event/store', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(event)
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        console.log("Event synced with server:", data);

        // Check if the event has a valid 'id'
        if (event.id) {
            deleteOfflineEvent(event.id); // Pass the correct key (event id) here
        } else {
            console.error("Event has no ID; cannot delete from IndexedDB.");
        }
    })
    .catch(error => {
        console.error("Sync failed:", error);
    });
}

// Function to delete synced offline event from IndexedDB
function deleteOfflineEvent(eventId) {
    const transaction = db.transaction(["events"], "readwrite");
    const objectStore = transaction.objectStore("events");

    // Ensure the eventId is valid
    if (eventId) {
        objectStore.delete(eventId); // Pass the correct id (primary key) for deletion
        console.log("Deleted offline event with ID:", eventId);
    } else {
        console.error("No valid event ID provided for deletion.");
    }
}

// Event listener for going online
window.addEventListener('online', syncOfflineData);

// Polling every 10 seconds to check if online and sync offline data
setInterval(() => {
    if (navigator.onLine) {
        syncOfflineData();
    }
}, 300000);
