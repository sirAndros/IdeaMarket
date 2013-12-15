/* Document Javascript */
window.addEvent('domready', function(){
	
	//add and remove class when mouse over LI
	var sfEls = document.id("ot-megaMenu").getElementsByTagName("LI");
	
	for (var i = 0; i<sfEls.length; ++i) {
		sfEls[i].onmouseover = function() {
			this.className += " sfhover";
		}
		sfEls[i].onmouseout = function() {
			this.className = this.className.replace(new RegExp(" sfhover\\b"), "");
		}
	}
	// 
	if(els = $$('li.hasChild ')) {
		els.each(function(el){
		
			el.getElements('div.submenu-wrap').setStyle('opacity', 0);
			//var getStyles = el.getElement('div.hasChild').getStyle('width'); //console.log(getStyles);
			
			el.addEvents({
				'mouseover': function(e) {
					if (el.getElements('div.submenu-wrap')) {
						//el.getElements('div.submenu-wrap').tween('opacity', 1);
						el.getElements('div.submenu-wrap').fade('in');
						el.getElements('div.submenu-wrap').setStyles({ 'display': 'block' });
					}
				},
				'mouseout': function(e) {
					if (el.getElements('div.submenu-wrap')) {
						//el.getElements('div.submenu-wrap').tween('opacity', 0);
						el.getElements('div.submenu-wrap').fade('out');
						el.getElements('div.submenu-wrap').setStyles({ 'display': 'none' });
					}
				}
			});
		})
	} 
});
/* End */






