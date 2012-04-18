<div class="modal-header">
	<h3>Пример модеального окна</h3>
</div>

<form class="post" action="./?action=main" method="POST" redirect="./?page=main">

<div class="modal-body">				
	<div class="alert alert-error">
		<a class="close" >×</a>
		<strong>Ошибка!</strong> <ul><li>Неизвестная ошибка.</li></ul>
	</div>
	<textarea class="tinymce big">{$block}</textarea>
</div>

<div class="modal-footer">
	<button type="submit" class="btn btn-primary">Сохранить</button>
	<button type="button" class="btn modal_cancel">Отменить</button>
</div>

</form>
<script type="text/javascript">
	ADM.init.modal();
</script>