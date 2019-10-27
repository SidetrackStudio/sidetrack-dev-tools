(function(){
	window.addEventListener("resize", sidetrackViewportSize);
})();
function sidetrackViewportSize() {
	let height = window.innerHeight;
	let width = window.innerWidth;
	var box = document.createElement("div");
	box.innerHTML = '<div id="viewportsize" class="salmon-js" style="z-index:9999;position:fixed;bottom:0px;left:0px;color:#fff;background:#d29;padding:10px">Height: ' + height + ' || Width: ' + width + '</div>';
	document.getElementById("site-content").appendChild(box);
}