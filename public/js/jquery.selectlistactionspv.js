(function () {
  $("#btnRight").click(function (e) {
    var selectedOpts = $("#ListaAplicacionesActuales option:selected");
    if (selectedOpts.length == 0) {
      alert("Seleccione al menos un evento.");
      e.preventDefault();
    }

    $("#ListaAplicaciones").append($(selectedOpts).clone());
    $(selectedOpts).remove();
    e.preventDefault();
  });

  $("#btnAllRight").click(function (e) {
    var selectedOpts = $("#ListaAplicacionesActuales option");
    if (selectedOpts.length == 0) {
      alert("Seleccione al menos un evento.");
      e.preventDefault();
    }

    $("#ListaAplicaciones").append($(selectedOpts).clone());
    $(selectedOpts).remove();
    e.preventDefault();
  });

  $("#btnLeft").click(function (e) {
    var selectedOpts = $("#ListaAplicaciones option:selected");
    if (selectedOpts.length == 0) {
      alert("Seleccione al menos un evento.");
      e.preventDefault();
    }

    $("#ListaAplicacionesActuales").append($(selectedOpts).clone());
    $(selectedOpts).remove();
    e.preventDefault();
  });

  $("#btnAllLeft").click(function (e) {
    var selectedOpts = $("#ListaAplicaciones option");
    if (selectedOpts.length == 0) {
      alert("Seleccione al menos un evento.");
      e.preventDefault();
    }

    $("#ListaAplicacionesActuales").append($(selectedOpts).clone());
    $(selectedOpts).remove();
    e.preventDefault();
  });

  //GEOCERCAS
  $("#btnRightGC").click(function (e) {
    var selectedOpts = $("#ListaGeocercas option:selected");
    if (selectedOpts.length == 0) {
      alert("Seleccione al menos una geocerca.");
      e.preventDefault();
    }

    $("#ListaGeocercasSeleccionadas").append($(selectedOpts).clone());
    $(selectedOpts).remove();
    e.preventDefault();
  });

  $("#btnAllRightGC").click(function (e) {
    var selectedOpts = $("#ListaGeocercas option");
    if (selectedOpts.length == 0) {
      alert("Seleccione al menos una geocerca.");
      e.preventDefault();
    }

    $("#ListaGeocercasSeleccionadas").append($(selectedOpts).clone());
    $(selectedOpts).remove();
    e.preventDefault();
  });

  $("#btnLeftGC").click(function (e) {
    var selectedOpts = $("#ListaGeocercasSeleccionadas option:selected");
    if (selectedOpts.length == 0) {
      alert("Seleccione al menos una geocerca.");
      e.preventDefault();
    }

    $("#ListaGeocercas").append($(selectedOpts).clone());
    $(selectedOpts).remove();
    e.preventDefault();
  });

  $("#btnAllLeftGC").click(function (e) {
    var selectedOpts = $("#ListaGeocercasSeleccionadas option");
    if (selectedOpts.length == 0) {
      alert("Seleccione al menos una geocerca.");
      e.preventDefault();
    }

    $("#ListaGeocercas").append($(selectedOpts).clone());
    $(selectedOpts).remove();
    e.preventDefault();
  });

  
})(jQuery);