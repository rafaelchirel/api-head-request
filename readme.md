# Librería PHP
Esta es una clase de php que sirve para obtener datos de cabecera mediante el navegador de turno que se esté usando, obteniendo dirección ip, datos de localización, sistema operativo y navegador. Desarrolle está clase para que pueda ser implementadas en proyectos web y de está manera ayudar con el proceso de auditoría.

## Requerimientos
  * php >= 5.6
  
## Git
```shell
git clone https://github.com/rafaelchirel/api-head-request.git
```

## Uso

``` php
// Requerir la clase
	require_once './api.php';

// importar la clase
	use Api\HeadRequest;

	/* Metodos de la Clase */

// Obtiene la IP, localización de la IP, Browser, Platform y MacAddress
	echo HeadRequest::headDataRequest();

// Obtiene solamente la Direccion IP
	echo HeadRequest::getIP();

// Obtiene la Direccion IP y los datos de Localización.
	echo HeadRequest::showDataIP();

// Obtiene el nombre del sistema operativo. Unix, Linux, Mac OS X y Win.
	echo HeadRequest::getPlatform();

// Obtiene el navegador de turno que se este usando.
	echo HeadRequest::getBrowser();

// Obtiene la Direccion Mac.
	echo HeadRequest::getCurrentMacAddress();
```


Para más información vea el archivo index.php. Puede ejecutar el index en la línea de comandos como root. `php index.php`
