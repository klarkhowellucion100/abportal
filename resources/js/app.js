import "./bootstrap";

console.log("Checking for service worker support...");

// if ("serviceWorker" in navigator) {
//     console.log("Service worker supported. Attempting to register...");
//     navigator.serviceWorker
//         .register("/sw.js")
//         .then((registration) => {
//             console.log(
//                 "Service Worker registered with scope:",
//                 registration.scope
//             );
//         })
//         .catch((error) => {
//             console.error("Service Worker registration failed:", error);
//         });
// } else {
//     console.error("Service workers are not supported in this browser.");
// }
