ADM.init.common = function() {
	//Расширяем настройками
	$.extend(ADM.settings, {
		animationSpeed: 450,
		animationSpeedFast: 200
	});

	// Подключаем сабмитер форм
	ADM.utils.formPost();
}

// Заглушка для переопределения доп функций модалки после загрузки
ADM.init.modal = function() {}

/*
 * Разъезжающееся меню сайдбара
 */
ADM.UI.sidebar = function() {
	$('.sidebar .nav-list > .active > ul').show();
	$('.sidebar .nav-list > .active .caret').addClass('active');
	$('.sidebar .nav-list > li').each(function(){
		if ($(this).find('ul').length !=1)
			$(this).find('.drop').hide();	
	})
	
		
	$('.sidebar .drop').live('click', function() {
		$(this).find('.caret').toggleClass('active');
		$(this).parent().next().slideToggle(500);
		return false;
	})
}


/*
 * Работа с модальными окнами
 */
ADM.UI.modal = function() {
	// Отмена
	$(".modal_cancel, .modal_close").live('click', function() {
		$("#modal").modal("hide");
	});
	
	// Загрузка окна
	$(".show_modal").click(function() {
		var hash = $(this).attr("modal").split("/");
		var url = "./?page=modal&object="+ hash[0] +"&method="+ hash[1];

		if (hash[2] != undefined)
			url += ("&id="+ hash[2]);

		$("#modal").modal({keyboard: true}).on("hidden", function() {
			$(this).html("<div class=\"modal-body\"><div id=\"loader\"></div></div>");
		}).load(url, function() {
			ADM.init.modal();
		}).error(function() {
			$(".modal-body ", modal).html("<div class=\"alert\">Не могу загрузить форму</div>");
		});
	});
}

/*
 * Переключение в модалке «команда»
 */
ADM.UI.toggleTeam = function() {
	$('.btn-group button.text').addClass('active');
	$('.group .block.link').hide();
	
	$('.btn-group button').live('click', function(){
		var att = $(this).attr('class').split(' ');
		$('.group .block').hide();
		$('.group .block.' + att[1]).show();
		return false;
	})
}



/*
 * Удаление проектов и статей
 */
ADM.utils.pDelete = function() {
	$(".delete").click(function() {
		if (!confirm("Вы действительно хотите удалить элемент?"))
			return false;

		var li = $(this).parents("li");
		var data = /(\w+)\/(\d+)$/i.exec(li.find("a.edit").attr("href"));

		ADM.utils.postRequest("./?action=delete", {type: data[1], id: data[2]}, function() {this.remove();}, li);
		return false;
	})
}

/**
 * Текстовый редактор
 * @var container Контейнер для редактора
 * @var buttons Список кнопок
 * @var plugins Список плагинов
 */
ADM.utils.textEditor = function(container, buttons, plugins, angry) {
	// Ждем пока контент не отредериться
	if (!angry) {
		setTimeout(function() {ADM.utils.textEditor.call(null, container, buttons, plugins, "yes")}, 300);
		return;
	}

	$(container).tinymce({
		// Путь к TinyMCE script
		script_url : '/adm/js/lib/tiny_mce/tiny_mce.js',

		// Общие настройки
		theme : "advanced",
		language: "ru",
		plugins : plugins,

		// Внешний вид
		theme_advanced_buttons1 : buttons,
		theme_advanced_buttons2 : "",
		
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",

		// CSS-файл
		//content_css : "/adm/css/main.css",

		relative_urls : false,
		remove_script_host : true
	});
}

/*
 * Работа с иллюстрациями проекта
 */
ADM.UI.imageEditor = {
	picDelete: function() {
		$('.delete').live('click', function(){
			if (!confirm("Вы действительно хотите удалить фотографию?"))
				return false;
			
			var li = $(this).parents("li");
			var id = li.find('input[name="photos[]"]').val();

			if (id.search(/[^\d]+/) == -1) // Если нам задан id-фотки
				ADM.utils.postRequest("./?action=delete", {type: "photo", id: id}, function() {this.remove()}, li); // то удалим ее из БД
			else					// Если это временный файл,
				li.remove();		// то просто удалим блок

			return false;
		});
	},
	picEdit: function() {
		$('.caption').live('dblclick', function(){
			$('<input type="text" placeholder="Подпись">').val($(this).text()).replaceAll(this).focus();
		});
	}
}

/*
 * Кастомная кнопка для загрузки фото
 */
ADM.UI.uploadCast = function(class_selector) {
	if(class_selector == undefined)
		class_selector = 'upload';

	var field = $("div."+ class_selector);
		main = new Array(800, 480);
		thumb = new Array(150, 90);
		side = 'big';
		thumb_side = 'big';

	if(field.attr("main") != undefined)
		main = field.attr("main").split("/");

	if(field.attr("thumb") != undefined)
		thumb = field.attr("thumb").split("/");

	if(field.attr("side") != undefined)
		side = field.attr("side");
	
	if(field.attr("thumb_side") != undefined)
		thumb_side = field.attr("thumb_side");

	
	$("."+class_selector).ocupload({
		name: 'photo',
		action: "/adm/?action=edit",
		enctype: "multipart/form-data",
		params: {
			object: "Photo",
			method: "Upload",
			width: main[0], 
			height: main[1],
			thumb_width: thumb[0], 
			thumb_height: thumb[1], 
			side: side, 
			thumb_side: thumb_side
		},
		autoSubmit: true,
		onSubmit: function() {
		},
		onComplete: function(data) {
			try {
				var res = eval("("+ data +")");
				if (res.result) {
					$(this.element).css("background-image", "url("+ res.thumb +")")
									.parents(".row").find("input[name*='photo']")
										.val(res.file.substr(res.file.lastIndexOf("/") + 1));
				}
				else {
					if(res.errors != undefined)
						ADM.UI.alert.show(res.errors);
					else if(res.desc != undefined)
						ADM.UI.alert.show(res.desc);
					else
						ADM.UI.alert.show(res);
				}
				$(this.loader).delay(ADM.settings.animationSpeed).fadeOut(ADM.settings.animationSpeed);
			} catch (e) {
				$(this.loader).delay(ADM.settings.animationSpeed).fadeOut(ADM.settings.animationSpeed);
			}
		},
		onSelect: function() {
			if (!this.loader) {
				$("<div>").attr("id", "loader").css({
								"background-color": "#FFF",
								"background-image": "url(images/ajax-loader.gif)",
								"background-position": "center center",
								"background-repeat": "no-repeat",
								display: "none",
								height: $(this.element).height(),
								position: "relative",
								top: (-1 * $(this.element).height()),
								width: $(this.element).width()
							}).insertAfter(this.element);
				this.loader = $(this.element).siblings("#loader");
			}
			$(this.loader).fadeIn(ADM.settings.animationSpeed);
		}
	});
}

/**
 * Сортировка элементов
 * @var what Контейнер (селектор контейнера) с элементами для сортировки
 * @var type Тип поля(div или li)
 * @var callback Обработчик
 */
ADM.utils.sortable = function (what, type, callback) {
	$(what).sortable({
		containment: 'window',
		opacity: 0.6,
		tolerance: 'pointer',
		cancel: ":input,button,.ui-sortable-no",
		start: function(ev, ui) {
			$(ui.item).addClass("sort-selected");
		},
		stop: function(ev, ui) {
			var nextOrder = ($(ui.item).next(type + "[order]").length > 0) ? parseFloat($(ui.item).next(type + "[order]").attr('order')) : 0;
			var prevOrder = ($(ui.item).prev(type + "[order]").length > 0) ? parseFloat($(ui.item).prev(type + "[order]").attr('order')) : 0;
			var thisOrder = null;

			if (nextOrder == 0)
				thisOrder = Math.ceil(prevOrder + 1);
			else if (prevOrder == 0)
				thisOrder = (nextOrder > 1) ? Math.floor(nextOrder - 1) : nextOrder / 2;
			else
				thisOrder = prevOrder + (nextOrder - prevOrder) / 2;

			$(ui.item).attr('order', thisOrder);
			
			if (callback != undefined)
				callback.call(ui.item, thisOrder);
		}
	});
}

/**
 * Сабмит post-формы
 */
ADM.utils.formPost = function() {
	$("form.post button[type=submit]").click(function() {
		var f = $(this).parents("form.post");
		ADM.utils.postRequest(f.attr("action"), f.serialize(), function() {
			if (f.attr("redirect") != undefined)
				window.location.href = f.attr("redirect");
			else
				ADM.UI.alert.show("Информация обновлена");
		});
		return false;
	});
}

/**
 * функция для отправки POST-запроса к серверу
 * @var url Адрес скрипта
 * @var data Передаваемые данные
 * @var callback Обработчик успешного результата операции, в качестве параметра передается ответ от сервера
 * @var context Контекст, в котором будет вызван обработчик, если не определен, то document
 */
ADM.utils.postRequest = function(url, data, callback, context) {
	$.ajax({
		url: url,
		data: data,
		type: "POST",
		dataType: "json",
		success: function(res) {
			if (res.result) {
				if (callback != undefined)
					callback.call((context != undefined) ? context : document, res);
			} else {
				if(res.errors != undefined)
					ADM.UI.alert.show(res.errors);
				else if(res.desc != undefined)
					ADM.UI.alert.show(res.desc);
				else
					ADM.UI.alert.show(res);
			}
		},
		error: function () {
			ADM.UI.alert.show("Произошла ошибка. Попробуйте еще раз.");
		}
	});
}

/**
 * Алерты в модальных окнах
 */
ADM.UI.alert = {
	show: function(message) {
		var error = '';
		if(typeof(message) && message.constructor == Array) {
			for(var key in message) {
				if(typeof(message[key])=='string')
					error = error +" <li>"+message[key]+"</li>";
			}
		} else if(typeof(message)=='string'){
			error = "<li>"+message+"</li>";
		}
		
		if(error.length == 0)
			error = 'Произошла ошибка.'
			
		$('.modal .alert ul').html(error);
		$('.modal .alert').animate({top: 0}, 500);
	},
	hide: function() {
		$('.modal .alert').animate({top: '-40px'}, 500, function() {
			$('.modal .alert ul').html('');	
		});
	}
}
