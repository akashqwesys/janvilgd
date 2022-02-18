// Import the functions you need from the SDKs you need
import { initializeApp } from "https://www.gstatic.com/firebasejs/9.6.6/firebase-app.js";
// import { getMessaging, isSupported as is1} from "https://www.gstatic.com/firebasejs/9.6.6/firebase-messaging.js";
import { getMessaging, onBackgroundMessage } from "https://www.gstatic.com/firebasejs/9.6.6/firebase-messaging-sw.js";
// import { getAnalytics, isSupported } from "https://www.gstatic.com/firebasejs/9.6.6/firebase-analytics.js";
// TODO: Add SDKs for Firebase products that you want to use
// https://firebase.google.com/docs/web/setup#available-libraries

// Your web app's Firebase configuration
// For Firebase JS SDK v7.20.0 and later, measurementId is optional
const firebaseConfig = {
    apiKey: "AIzaSyAPzNIRChBF70ycP9RMi0SYDquRWG1LTOw",
    authDomain: "janvi-lgd.firebaseapp.com",
    projectId: "janvi-lgd",
    storageBucket: "janvi-lgd.appspot.com",
    messagingSenderId: "152003953916",
    appId: "1:152003953916:web:1b15b4d05e7e12c1070379",
    measurementId: "G-L74PSGLSF4"
};

// Initialize Firebase
const app = initializeApp(firebaseConfig);
// const analytics = getAnalytics(app);

// Retrieve an instance of Firebase Messaging so that it can handle background messages.

const messaging = getMessaging(app);

/* onBackgroundMessage(messaging, (payload) => {
    // console.log(payload);
    // Customize notification here
    const notificationTitle = 'Hi there';
    const notificationOptions = {
        body: 'Looking good',
        icon: '/admin_assets/images/logo-small.png'
    };

    return self.registration.showNotification(notificationTitle, notificationOptions);
}); */