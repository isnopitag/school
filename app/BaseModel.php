<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//TODO Este import de aqui abajo es imporatante porque si no no va a retonar la imagen.
use Illuminate\Support\Facades\Storage;

class BaseModel extends Model
{
    protected $fillable = ['title', 'description', 'image', 'where', 'when', 'created_at', 'updated_at'];

    //TODO: Con esta propiedad del modelo se le indica a Laravel si quieres evitar enviar ciertos fields en tu respuesta
    protected $hidden = ['created_at', 'updated_at']; //TODO: Spoiler si haces un select * a la tabla sin lo usual de Eloquent le va a valer madres que hayas puesto el hidden.


    //TODO Si aun se utiliza la libreria de Krlove Model Generator aqui solo se toman los metodos que por lo regular se utilizan y no se agregan


    //TODO Si el proyecto requiere el uso de imagenes se necesita poner este metodo en cada uno de los modelos que lo requieran
    public function getImageAttribute($image){

        //TODO el metodo lleva por nombre GetImageAttribute si en lugar de ser un Image el campo de imagen fuera un profile_picture
        //TODO El metodo se llamaria getProfilePictureAttribute
        //TODO este proceso de llamar asi el metodo  se llama Accesor en modelo


        //Esto es logica del metodo para devolver la URL desde la seccion de discos con el nombre que esta en la base de datos.
        //O bien como a mi me gustaba agregar imagenes falsas regresa la url de otro servidor, no hay tos el Laravel no la hace de tos.
        if(!$image || starts_with($image, 'http')){
            return $image;
        }
        return Storage::disk('public')->url($image);
    }

    //TODO: Este metodo tambien es un accesor, este se utiliza cuando se actualiza el field de la imagen, ¿Para que? para borrarla del directorio con funciones dentro del controlador.
    //TODO: Como quiera
    public function imageName()
    {
        return $this->attributes['image'];
    }
}
