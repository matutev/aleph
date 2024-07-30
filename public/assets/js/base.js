class Base{

    /**
     * Se inicializan las funciones
     * 
     */
    constructor(controller = ""){
        this.controller = controller;
        this.initFunctions();
    }

    /**
     * Si se muestra el dialog, quedara visible 1 seg y luego se ocultara
     * 
     */
    hideDialog(){
  
        let isDialogActive      = $('#dialog').children().length;
        let isCategoriasTable   = $('#categoriasTable').length;

        if(isDialogActive && isCategoriasTable){
            setTimeout(function () {
                $('#dialog').removeClass('d-block');
            }, 2000); 
        }
    }

    /**
     * Metodos que se llaman en el constructor y se disparan al interactuar en el DOM
     */
    initFunctions(){

        $(function() {
            base.hideDialog();
        });   

    }
}

var base = new Base();
