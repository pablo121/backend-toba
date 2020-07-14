#!/bin/bash

echo "memory_limit = 256M" >> /usr/local/etc/php/php.ini

if [ -z "**** $TOBA_ID_DESARROLLADOR" ]; then
    TOBA_ID_DESARROLLADOR=0;
fi

if [ -z "$TOBA_INSTANCIA" ]; then
    echo "**** TOBA_INSTANCIA - DEFECTO - desarrollo ****";
    TOBA_INSTANCIA='desarrollo';
fi
if [ -z "$TOBA_INSTALACION_DIR" ]; then
    echo "**** TOBA_INSTALACION_DIR - DEFECTO - /app/instalacion";
    TOBA_INSTALACION_DIR='/app/instalacion';
fi

#BASE DE DATOS
if [ -z "$BD_HOST" ]; then
    echo "**** FALTA HOST DE BD";
    exit;
fi
if [ -z "$BD_PORT" ]; then
    echo "**** BD_PORT - DEFECTO - 5432";
    BD_PORT=5432; 
fi
if [ -z "$BD_USER" ]; then
    echo "**** BD_USER - DEFECTO - postgres";
  	BD_USER=postgres; 
fi
if [ -z "$BD_PASSWORD" ]; then
    echo "**** BD_PASSWORD - DEFECTO - postgres";
    BD_PASSWORD=postgres; 
fi

#VARIABLES DE CONFIGURACION DEL PROYECTO
if [ -z "$PROYECTO" ]; then
    echo "**** PROYECTO - DEFECTO - NUEVO";
    PROYECTO='NUEVO';
fi

if [ -z "$PROYECTO_NAME" ]; then
    echo "**** PROYECTO_NAME - DEFECTO - test";
    PROYECTO_NAME='test';
fi
if [ -z "$BD_NEGOCIO" ]; then
    echo "**** BD_NEGOCIO - DEFECTO - bd_test";
    BD_NEGOCIO='bd_negocio';
fi

if [ -z "$TOBA_PASS" ]; then
    echo "**** TOBA_PASS - DEFECTO - toba (OjO)";
    TOBA_PASS=toba;
fi

HOME_GESTION=/app/aplicacion
HOME_TOBA=/app/toba
if [ ! -d ${HOME_TOBA} ]; then
	mkdir ${HOME_TOBA}
fi

export PROYECTO_NAME=${PROYECTO_NAME}
export TOBA_INSTANCIA=${TOBA_INSTANCIA}
export TOBA_INSTALACION_DIR=${TOBA_INSTALACION_DIR}

if [ ! -d ${HOME_TOBA}/vendor ]; then
	cd /tmp
	echo "**** Clonando repositorio en "${HOME_TOBA}
	git clone https://github.com/SIU-Toba/template-proyecto-toba.git
	mv /tmp/template-proyecto-toba/* ${HOME_TOBA}
	echo "**** composer "
	composer install -d ${HOME_TOBA}/
else
	cd ${HOME_TOBA}
	composer update -d ${HOME_TOBA}/
fi


if [ -z "$(ls -A "$TOBA_INSTALACION_DIR")" ]; then
        # if [ -z "$DOCKER_WAIT_FOR" ]; then
                #Ahora chequeo que se pueda hacer una conexion (pg_isready similar)
              # ${HOME_TOBA}/bin/connection_test pg 5432 postgres postgres postgres;		
		# fi
    echo -n ${BD_PASSWORD} > /tmp/clave_pg;
    echo -n ${TOBA_PASS} > /tmp/clave_toba;
    ${HOME_TOBA}/bin/toba instalacion instalar ${TOBA_ID_DESARROLLADOR} -n ${TOBA_INSTANCIA} -t 0 -h ${BD_HOST} -p ${BD_PORT} -u postgres -b toba -c /tmp/clave_pg -k /tmp/clave_toba;
    
    
    if [ "$PROYECTO" = "NUEVO" ]; then
        echo '****NUEVO'
    	${HOME_TOBA}/bin/toba proyecto crear -d ${HOME_GESTION} -p ${PROYECTO_NAME} -i desarrollo -a 1;
    else
        echo '**** CARGANDO'
    	${HOME_TOBA}/bin/toba proyecto cargar -d ${HOME_GESTION} -p ${PROYECTO_NAME} -i desarrollo -a 1;	
    fi

    

    # Instalar los juegos de dato de prueba (Actualmente no se estan mantieniendo mas los datos de prueba)
#    printf "\n" | ${HOME_GESTION}/bin/guarani instalar;

    # Específico de Guaraní
    echo 'chequea_sincro_svn = 1' >> ${TOBA_INSTALACION_DIR}/instalacion.ini;
    echo "menu = 2" > ${HOME_GESTION}/menu.ini;

    # Permite a Toba guardar los logs
    chown -R www-data ${TOBA_INSTALACION_DIR}/i__desarrollo;

    # Permite al usuario HOST editar los archivos
    chmod -R a+w ${TOBA_INSTALACION_DIR}
fi

TOBA_CONF=toba_${PROYECTO_NAME}.conf

#configuramos url del proyecto
sed -i "s/toba_editor\/3.3/${PROYECTO_NAME}\/editor/g" \
    ${TOBA_INSTALACION_DIR}/toba.conf
sed -i "s/toba_usuarios\/3.3/${PROYECTO_NAME}\/usuarios/g" \
    ${TOBA_INSTALACION_DIR}/toba.conf
sed -i "s/${PROYECTO_NAME}\/1.0/${PROYECTO_NAME}/g" \
    ${TOBA_INSTALACION_DIR}/toba.conf
sed -i "s/toba_editor\/3.3/${PROYECTO_NAME}\/editor/g" \
    ${TOBA_INSTALACION_DIR}/i__desarrollo/instancia.ini
sed -i "s/toba_usuarios\/3.3/${PROYECTO_NAME}\/usuarios/g" \
    ${TOBA_INSTALACION_DIR}/i__desarrollo/instancia.ini
sed -i "s/${PROYECTO_NAME}\/1.0/${PROYECTO_NAME}/g" \
    ${TOBA_INSTALACION_DIR}/i__desarrollo/instancia.ini

ln -s ${TOBA_INSTALACION_DIR}/toba.conf /etc/apache2/sites-enabled/${TOBA_CONF};
ln -s ${TOBA_INSTALACION_DIR}/toba.conf /etc/apache2/sites-available/${TOBA_CONF};

#Se deja el ID del container dentro de la configuración de toba, para luego poder usarlo desde el Host
DOCKER_CONTAINER_ID=`cat /proc/self/cgroup | grep -o  -e "docker-.*.scope" | head -n 1 | sed "s/docker-\(.*\).scope/\\1/"`
echo "TOBA_DOCKER_ID=$DOCKER_CONTAINER_ID" > ${TOBA_INSTALACION_DIR}/toba_docker.env

#Cada vez que se loguea por bash al container, carga las variables de entorno toba
SCRIPT_ENTORNO_TOBA=`find ${TOBA_INSTALACION_DIR}/entorno_toba.env`
echo ". ${SCRIPT_ENTORNO_TOBA}" > /root/.bashrc
echo "export TERM=xterm;" >> /root/.bashrc