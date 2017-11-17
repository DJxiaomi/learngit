var Lx = window.Lx || {};
Lx.common = (function(){
	return {
		_attachEvent: function(obj, evt, func, eventobj) {
			eventobj = !eventobj ? obj : eventobj;
			if(obj.addEventListener) {
				obj.addEventListener(evt, func, false);
			} else if(eventobj.attachEvent) {
				obj.attachEvent('on' + evt, func);
			}
		},
		lazyload: function() {
			var obj = this, lazyload = [];
			this.getOffset = function (el, isLeft) {
				var  retValue  = 0 ;
				while  (el != null ) {
					retValue  +=  el["offset" + (isLeft ? "Left" : "Top" )];
					el = el.offsetParent;
				}
				return  retValue;
			};
			this.initImages = function () {
				lazyload.imgs = [];
				var eles = [document.body];
				for (var i = 0; i < eles.length; i++) {
					var imgs = eles[i].getElementsByTagName('IMG');
					for(var j = 0; j < imgs.length; j++) {
						if(imgs[j].getAttribute('data-lazyload') && !imgs[j].getAttribute('lazyloaded')) {
							if(this.getOffset(imgs[j]) > document.documentElement.clientHeight) {
								lazyload.imgs.push(imgs[j]);
							} else {
								imgs[j].setAttribute('src', imgs[j].getAttribute('data-lazyload'));
								imgs[j].setAttribute('lazyloaded', 'true');
							}
						}
					}
				}
			};
			this.showImage = function() {
				this.initImages();
				if(!lazyload.imgs.length) return false;
				var imgs = [];
				var scrollTop = Math.max(document.documentElement.scrollTop , document.body.scrollTop);
				for (var i=0; i<lazyload.imgs.length; i++) {
					var img = lazyload.imgs[i];
					var offsetTop = this.getOffset(img);
					if (!img.getAttribute('lazyloaded') && offsetTop > document.documentElement.clientHeight && (offsetTop  - scrollTop < document.documentElement.clientHeight)) {
						var dom = document.createElement('div');
						var width = img.getAttribute('width') ? img.getAttribute('width') : $(img).parent().width();
						var height = img.getAttribute('height') ? img.getAttribute('height') : $(img).parent().width();
						dom.innerHTML = '<div style="width: '+width+'px; height: '+height+'px;font-size:2rem;color:#666;line-height:'+height+'px;text-align:center;"><i class="icon-spinner icon-spin"></i></div>';
						img.parentNode.insertBefore(dom.childNodes[0], img);
						img.onload = function () {
							if(!this.getAttribute('_load')) {
								this.setAttribute('_load', 1);
								this.style.width = this.style.height = '';
								this.style.display = '';
								this.parentNode.removeChild(this.previousSibling);
							}
						};
						img.style.width = img.style.height = '0px';
						img.style.display = 'none';
						img.setAttribute('src', img.getAttribute('data-lazyload') ? img.getAttribute('data-lazyload') : img.getAttribute('src'));
						img.setAttribute('lazyloaded', true);
					} else {
						imgs.push(img);
					}
				}
				lazyload.imgs = imgs;
				return true;
			};
			this.showImage();
			Lx.common._attachEvent(window, 'scroll', function(){obj.showImage();});
		},
		loading: function(){
			var loading = '<div class="lx-loading"><i class="icon-spinner icon-spin"></i></div>';
			$('body').append(loading).show();
		},
		loadingClose: function(){
			$('.lx-loading').hide().remove();
		}
	}
})();