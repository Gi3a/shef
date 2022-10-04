(function() { 
	class Menu { 
		constructor(menu, btns) { 
			this.menu = document.querySelector(menu); 
			this.toggleMenu = this.toggleMenu.bind(this); 
			for (var i = 0; i < btns.length; i++) {
                var btn = document.querySelector(btns[i]);
                btn.addEventListener('click', this.toggleMenu);
            }
		} 
		toggleMenu(e) { 
            e.preventDefault(); 
            if (this.menu.classList.contains('open')) {
            var openElements = document.querySelectorAll('.open'); 
                Array.prototype.forEach.call(openElements, function(el) {
                    el.classList.remove('open');
                }) 
            } else { 
                var openElements = document.querySelectorAll('.open');
                Array.prototype.forEach.call(openElements, function(el) {
                    el.classList.remove('open');
                })
                this.menu.classList.add('open'); 
            } 
        }
	} 
	var menu = new Menu('#menu', ['#btn-menu']); 

	var menu2 = new Menu('#profile', ['#btn-profile']);
}())