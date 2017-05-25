//Inicia el cambio de Lenguaje
fncChangeLanguage();

function fncChangeLanguage(){

	$('.lang-h2-welcome').html('Bienvenido');
	$('.lang-h2-register').html('Registrar');
	$('.lang-h2-new-business').html('nueva empresa');
	$('.lang-h2-new-user').html('nuevo usuario');
	$('.lang-h2-list-business').html('lista de empresas');
	$('.lang-h2-list-user').html('lista de usuarios');
	$('.lang-h2-type-user').html('nuevo tipo de usuario');
	$('.lang-h2-list-type-user').html('lista de tipos de usuarios');
	$('.lang-h2-new-product').html('nuevo producto');
	$('.lang-h2-list-product').html('lista de productos');
	$('.lang-h2-new-version').html('nueva versión');
	$('.lang-h2-list-version').html('lista de versiones');
	$('.lang-h2-link-version-product').html('vincular versión x producto');
	$('.lang-h2-list-version-product').html('lista de versiones x productos');
	
	$('.lang-h3-ser').html('servicios');
	$('.lang-h3-adm').html('administrador');
	
	$('.lang-label-name-business').html('Nombre Empresa');
	$('.lang-label-name-user').html('Nombre Usuario');
	$('.lang-label-ruc').html('Ruc');
	$('.lang-label-password').html('Contraseña');
	$('.lang-label-repeat-password').html('Repita Contraseña');
	$('.lang-label-business').html('Empresa');
	$('.lang-label-language').html('Idioma');
	$('.lang-label-user-type').html('Tipo Usuario');
	$('.lang-label-description').html('Descripción');
	$('.lang-label-description-en').html('Descripción en Inglés');
	$('.lang-label-name').html('Nombre');
	$('.lang-label-icon').html('Icono');
	$('.lang-label-version').html('Versión');
	$('.lang-label-product').html('Producto');
	$('.lang-label-registration-date').html('Fecha Registro');
	$('.lang-label-filename').html('Nombre de Archivo');
	$('.lang-label-file-upload').html('Cargar Archivo');
	
	$('.lang-span-business').html('empresa');
	$('.lang-span-user').html('usuario');
	$('.lang-span-product').html('producto');
	$('.lang-span-content').html('contenido');
	$('.lang-span-version').html('Versión');
	$('.lang-span-file').html('Subir Archivo');
	$('.lang-span-url').html('Desde URL');
	$('.lang-span-all').html('Ver Todo');
	$('.lang-span-update').html('Actualizado el');
	$('.lang-span-list').html('Ver Modo Lista');
	$('.lang-span-grid').html('Ver Modo Grilla');
	$('.lang-span-published').html('Publicado el');

	$('.lang-a-new-business').html('nueva empresa');
	$('.lang-a-new-user').html('nuevo usuario');
	$('.lang-a-user-type').html('tipo usuario');
	$('.lang-a-register-product').html('registrar producto');
	$('.lang-a-register-version').html('registrar versión');
	$('.lang-a-link-version-product').html('vincular versión & producto');
	$('.lang-a-register-update').html('registrar actualización');
	$('.lang-a-register-correction').html('registrar corrección');
	$('.lang-a-register-manual').html('registrar manual');
	$('.lang-a-register-video').html('registrar video');
	$('.lang-a-help').html('Ayuda');
	$('.lang-a-logout').html('Cerrar sesión');

	$('.lang-small-texto').html('Complete los campos');
	$('.lang-small-information-recent').html('Información reciente...');
	
	$('.lang-option-select').html('-- Seleccione --');

	$('.lang-button-reset').html('Limpiar');
	$('.lang-button-save').html('Guardar');
	$('.lang-button-update').html('Actualizar');
	$('.lang-button-edit').html('Editar');
	$('.lang-button-delete').html('Eliminar');
	$('.lang-button-download').html('Descargar');
	$('.lang-button-download-pdf').html('Descargar PDF');

	$('.lang-th-no').html('N°');
	$('.lang-th-business').html('Empresa');
	$('.lang-th-ruc').html('Ruc');
	$('.lang-th-language').html('Idioma');
	$('.lang-th-registration-date').html('Fecha Registro');
	$('.lang-th-state').html('Estado');
	$('.lang-th-actions').html('Acciones');
	$('.lang-th-user').html('Usuario');
	$('.lang-th-type').html('Tipo');
	$('.lang-th-description').html('Descripción');
	$('.lang-th-icon').html('Icono');
	$('.lang-th-name').html('Nombre');
	$('.lang-th-version').html('Versión');
	$('.lang-th-product').html('Producto');
	$('.lang-th-date').html('Fecha');

	$('#detail-description').attr('placeholder', 'Ingrese descripción en español...');
	$('#detail-description-en').attr('placeholder', 'Ingrese descripción en inglés...');
}
