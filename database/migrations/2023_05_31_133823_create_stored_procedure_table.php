<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stored_procedure', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('examname')->nullable();
            $table->string('email')->unique();
            $table->text('password');
            $table->string('gender')->nullable();
            $table->string('dob')->nullable();
            $table->string('picture')->nullable();
            $table->text('bio')->nullable();
            $table->timestamps();
        });

        // Create INSERT stored procedure
        DB::unprepared('
            CREATE PROCEDURE insert_stored_procedure (
                IN p_name VARCHAR(255),
                IN p_examname TEXT,
                IN p_email VARCHAR(255),
                IN p_password TEXT,
                IN p_gender VARCHAR(255),
                IN p_dob VARCHAR(255),
                IN p_picture VARCHAR(255),
                IN p_bio TEXT
            )
            BEGIN
                INSERT INTO stored_procedure (name, examname, email, password, gender, dob, picture, bio)
                VALUES (p_name, p_examname, p_email, p_password, p_gender, p_dob, p_picture, p_bio);
            END
        ');

        // Create UPDATE stored procedure
        DB::unprepared('
            CREATE PROCEDURE update_stored_procedure (
                IN p_id INT,
                IN p_name VARCHAR(255),
                IN p_examname TEXT,
                IN p_email VARCHAR(255),
                IN p_password TEXT,
                IN p_gender VARCHAR(255),
                IN p_dob VARCHAR(255),
                IN p_picture VARCHAR(255),
                IN p_bio TEXT
            )
            BEGIN
                UPDATE stored_procedure
                SET name = p_name,
                    examname = p_examname,
                    email = p_email,
                    password = p_password,
                    gender = p_gender,
                    dob = p_dob,
                    picture = p_picture,
                    bio = p_bio
                WHERE id = p_id;
            END
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stored_procedure');
    }
};
