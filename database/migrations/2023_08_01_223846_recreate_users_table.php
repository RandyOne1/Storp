<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RecreateUsersTable extends Migration
{
    public function up()
    {
        Schema::dropIfExists('users'); // Eliminar la tabla existente si existe

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('apellido_paterno'); // Nuevo campo 'apellido_paterno'
            $table->string('apellido_materno'); // Nuevo campo 'apellido_materno'
            $table->boolean('status')->default(true); // Nuevo campo 'status'
            $table->enum('privilegios', ['alumno', 'profesor', 'administrador'])->default('alumno'); // Nuevo campo 'privilegios'
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}
