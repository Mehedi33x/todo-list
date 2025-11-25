function getGreeting() {
    const now = new Date();
    const hour = now.getHours();
    let greeting;
    if (hour >= 0 && hour < 12) {
        greeting = "Good Morning";
    } else if (hour >= 12 && hour < 15) {
        greeting = "Good Noon";
    } else if (hour >= 15 && hour < 18) {
        greeting = "Good Afternoon";
    } else {
        greeting = "Good Evening";
    }
    return greeting;
}
