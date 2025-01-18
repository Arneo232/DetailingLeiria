package com.example.amsi.modelo;

import android.content.ContentValues;
import android.content.Context;
import android.database.Cursor;
import android.database.sqlite.SQLiteDatabase;
import android.database.sqlite.SQLiteOpenHelper;
import android.util.Log;

import androidx.annotation.Nullable;

public class UtilizadorBDHelper extends SQLiteOpenHelper {
    private static final String DB_NAME = "BDUsers";
    public static final String TABLE_NAME = "UsersTable";
    private static final int DB_VERSION = 18;
    private SQLiteDatabase db;

    public static final String USERNAME = "username", EMAIL = "email", ID = "id", IDPROFILE = "idprofile", MORADA = "morada",
            NTELEFONE = "ntelefone", TOKEN = "token";

    public UtilizadorBDHelper(@Nullable Context context) {
        super(context, DB_NAME, null, DB_VERSION);
        db = getWritableDatabase();
    }

    @Override
    public void onCreate(SQLiteDatabase db) {
        String sqlTableUtilizadores = "CREATE TABLE " + TABLE_NAME + "(" +
                ID + " INTEGER PRIMARY KEY AUTOINCREMENT," +
                IDPROFILE + " INTEGER," +
                USERNAME + " TEXT NOT NULL," +
                EMAIL + " TEXT NOT NULL," +
                NTELEFONE + " TEXT," +
                MORADA + " TEXT," +
                TOKEN + " TEXT NOT NULL);";

        db.execSQL(sqlTableUtilizadores);
    }

    public Utilizador adicionarUtilizadorBD(Utilizador utilizador) {
        ContentValues values = new ContentValues();

        values.put(USERNAME, utilizador.getUsername());
        values.put(EMAIL, utilizador.getEmail());
        values.put(NTELEFONE, utilizador.getNtelefone());
        values.put(MORADA, utilizador.getMorada());
        values.put(TOKEN, utilizador.getToken());

        db.insert(TABLE_NAME, null, values);

        return utilizador;
    }
    public boolean editarUtilizadorBD(Utilizador utilizador){
        ContentValues values = new ContentValues();
        values.put(USERNAME, utilizador.getUsername());
        values.put(EMAIL, utilizador.getEmail());
        values.put(NTELEFONE, utilizador.getNtelefone());
        values.put(MORADA, utilizador.getMorada());
        values.put(TOKEN, utilizador.getToken());

        int nLinhasEdit = (int) db.update(TABLE_NAME,values, ID + " = ?", new String[] {utilizador.getId()+""});
        return nLinhasEdit>0;
    }

    @Override
    public void onUpgrade(SQLiteDatabase db, int oldVersion, int newVersion) {
        db.execSQL( "DROP TABLE IF EXISTS " + TABLE_NAME);
        onCreate(db);
    }

    public String getUsernameById(int userId) {
        SQLiteDatabase db = this.getReadableDatabase();
        String username = null;

        Cursor cursor = db.query(
                "UtilizadoresTable",
                new String[]{"username"},
                "id = ?",
                new String[]{String.valueOf(userId)},
                null,
                null,
                null
        );

        try {
            if (cursor != null && cursor.moveToFirst()) {
                int columnIndex = cursor.getColumnIndex("username");

                if (columnIndex != -1) {
                    username = cursor.getString(columnIndex);
                } else {
                    // Log an error or handle the situation where "username" column is not found
                    Log.d("TAG", "getUsernameById: " + "username column not found");
                }
            }
        } finally {
            if (cursor != null) {
                cursor.close();
            }
        }
        return username;
    }
}
