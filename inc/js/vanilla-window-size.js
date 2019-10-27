
window.addEventListener("resize", showViewPortSize);

// -----------
// Debugger that shows view port size. Helps when making responsive designs.
// -----------
function showViewPortSize() {
		let height = window.innerHeight;
		let width = window.innerWidth;
		let body = document.querySelector('body');
		let addedDiv = document.createElement("div");
		addedDiv.innerHTML = '<div id="viewportsize" class="salmon-js" style="z-index:9999;position:fixed;bottom:0px;left:0px;color:#fff;background:#d29;padding:10px">Height: ' + height + ' || Width: ' + width + '</div>';
}
