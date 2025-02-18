function updateSubmenuOptions() {
    const tipo_dm = document.getElementById('tipo_dm');
    const busqueda_dm = document.getElementById('busqueda_dm');

    const selectedOption = tipo_dm.value;

    // Limpiar opciones anteriores del segundo menú
    while (busqueda_dm.firstChild) {
      busqueda_dm.removeChild(busqueda_dm.firstChild);
    }

    // Agregar opciones al segundo menú según la opción seleccionada en el primer menú
    if (selectedOption === 'proyecto') {
      addOptionToSubmenu('Nombre del proyecto', 'nombre_proyecto');
      addOptionToSubmenu('Año y periodo de presentación', 'Añoyperiodo');
      addOptionToSubmenu('Integrantes', 'integrantes');
      addOptionToSubmenu('Líder de equipo', 'lider');
      addOptionToSubmenu('Asesor', 'asesor');
      addOptionToSubmenu('Porcentaje de avance', 'porcentaje');
    } else if (selectedOption === "tesis" || selectedOption === "tesina" || selectedOption === "estadias"){
      addOptionToSubmenu('Titulo', 'titulo_proyecto');
      addOptionToSubmenu('Nombre del alumno', 'nombre_alumno');
      addOptionToSubmenu('Matricula', 'matricula');
      addOptionToSubmenu('Categoría', 'categoria');
      addOptionToSubmenu('Empresa', 'empresa');
      addOptionToSubmenu('Año', 'año');
      addOptionToSubmenu('Mes', 'mes');
      addOptionToSubmenu('Asesores', 'asesores');
    }
    else if (selectedOption === "otro"){
        addOptionToSubmenu('Reporte de servicio social', 'RpSs');
        addOptionToSubmenu('Reporte de estancias', 'RpEstan');
        addOptionToSubmenu('Poster', 'poster');
    }
    }


  function addOptionToSubmenu(label, value) {
    const option = document.createElement('option');
    option.text = label;
    option.value = value;
    document.getElementById('busqueda_dm').appendChild(option);
  }

  // Llamar a la función de actualización de opciones del segundo menú al cargar la página
  window.onload = updateSubmenuOptions;
