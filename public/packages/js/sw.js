if ("serviceWorker" in navigator && __ROOT__) {
	window.addEventListener("load", () => {
		navigator.serviceWorker
			.register(window.__ROOT__ + "/sw-listeners.js")
			.then(reg => {
				if (reg.installing) {
					console.log("Service worker installing");
				} else if (reg.waiting) {
					console.log("Service worker installed");
				} else if (reg.active) {
					console.log("Service worker active");
				}
			})
			.catch(error => {
				// registration failed
				console.log("Registration failed with " + error);
			});
	});
}
