<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Role (nếu bạn đã có bảng roles, để khóa ngoại nếu muốn)
            Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'role_id')) {
                $table->unsignedBigInteger('role_id')->nullable();
            }
            });


            // Profile fields
            $table->string('full_name')->nullable()->after('email');
            $table->date('birth_date')->nullable()->after('full_name');
            $table->string('position')->nullable()->after('birth_date'); // student, teacher, master, doctor
            $table->string('academic_title')->nullable()->after('position'); // cử nhân, thạc sĩ...
            $table->string('avatar')->nullable()->after('academic_title');

            // Verification
            $table->boolean('is_verified_teacher')->default(false)->after('avatar');
            $table->string('verification_document')->nullable()->after('is_verified_teacher');

            // Nếu bạn muốn FK với bảng roles (nếu có)
            // $table->foreign('role_id')->references('id')->on('roles')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Nếu bạn tạo FK, dropForeign trước
            // $table->dropForeign(['role_id']);
            $table->dropColumn([
                'role_id',
                'full_name',
                'birth_date',
                'position',
                'academic_title',
                'avatar',
                'is_verified_teacher',
                'verification_document',
            ]);
        });
    }
};
