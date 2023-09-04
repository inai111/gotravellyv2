import Cropper from "cropperjs";
import Dropzone from "dropzone";

const a =(b)=>document.querySelector(b);

let optionsCropper = {
    viewMode        : 1,
    dragMode        : "move",
    aspectRatio:1/1,
    maxHeigth:200,
    maxWidth:200,
    autoCropArea    : 1,
    zoom            : 0.1,
    preview:'.img-preview'
};
let modalCropper = {
    elem:a('.modal#cropping'),
    cropper:null,
    cropperData:null,
    dzRelate:null,
    setDzRelate:function(dz){this.dzRelate = dz},
    file:null,
    setFile:function(file){this.file=file},
    initCropper:function(){
        return new Cropper(this.elem.querySelector('.modal-body img'),optionsCropper);
    },
    modal:new bootstrap.Modal(a('.modal#cropping')),
    showModal:function(){
        if(!this.dzRelate) return;
        this.modal.show();
        if(!this.cropper) this.cropper = this.initCropper();
        console.log(this.cropper)
        let imgSrc = this.elem.querySelector('.modal-body img').src;
        this.cropper.replace(imgSrc);
        window.c = modalCropper.dzRelate
        let handleClickModalCropper = function(e){
            switch(this.id){
                case`crop`:
                    modalCropper.dzRelate.on('sending',function(file,xhr,formdata){
                        for(const[idx,val] of Object.entries(modalCropper.cropper.getData())){
                            formdata.append(idx,val)
                        }
                    })
                    modalCropper.dzRelate.processFile(modalCropper.file);
                    break;
                case`cropReset`:
                    modalCropper.cropper.reset();
                break;
            }
        };

        this.elem.querySelectorAll('button[type=button]').forEach(el => {
            el.addEventListener('click',handleClickModalCropper);
        });
        this.elem.addEventListener('hide.bs.modal',_=>{
            // hapus semua listener
            this.elem.querySelectorAll('button[type=button]').forEach(el => {
                el.addEventListener('click',handleClickModalCropper);
            });
        },{once:1})
    },
    closeModal:function(){
        this.modal.hide();
    },
}

window.modal = modalCropper

let fileTempDropzone = null;

let logo = new Dropzone(a(`div.dropzone`),{
    url:"/upload",
    // withCredentials:1,
    paramName:'logo',
    params:{
        'aaa':'asd'
    },
    acceptedFiles:"image/*",
    createImageThumbnails:0,
    resizeQuality:1,
    maxFiles:1,
    headers:{
        "X-CSRF-TOKEN":a(`meta[name=csrf-token]`).content
    },
    disablePreviews:1,
    dictDefaultMessage:`<h1>HOOOH</h1>`,
    autoProcessQueue:0,
    addedfile(file){
        let fileRead = new FileReader();
        fileTempDropzone = file;
        fileRead.onload = function(e){
            modalCropper.elem.querySelector('.modal-body img').src = e.target.result;
            modalCropper.setDzRelate(logo);
            modalCropper.setFile(file);
            modalCropper.showModal();
        };
        fileRead.readAsDataURL(file);
        this.removeFile(file);
    },
    complete(file){
        let response = JSON.parse(file.xhr.response)
        let url = response.url;

        this.element.style.backgroundImage = `url(${url})`;
        // console.log(this.element)
        modalCropper.closeModal();
    }
})

