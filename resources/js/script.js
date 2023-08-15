(function(){
    const forms = document.querySelectorAll(`form.needs-validation`);

    forms.forEach(form=>{
        form.addEventListener('submit',function(event){
            if(!form.checkValidity()){
                event.stopPropagation();
                event.preventDefault();
            }

            form.classList.add('was-validated')
        },false);
    })
})();