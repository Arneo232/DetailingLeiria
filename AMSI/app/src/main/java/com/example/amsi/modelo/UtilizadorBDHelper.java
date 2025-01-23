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
    private Context context;

    public static final String USERNAME = "username", EMAIL = "email", ID = "id", IDPROFILE = "idprofile", MORADA = "morada",
            NTELEFONE = "ntelefone", TOKEN = "token";

    public UtilizadorBDHelper(@Nullable Context context) {
        super(context, DB_NAME, null, DB_VERSION);
        this.context = context;
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
        values.put(IDPROFILE, utilizador.getIdprofile());

        Log.d("UPDATE", "Atualizando utilizador com ID: " + utilizador.getId());

        int nLinhasEdit = (int) db.update(TABLE_NAME, values, ID + " = ?", new String[]{String.valueOf(utilizador.getId())});

        Log.d("UPDATE", "Linhas afetadas: " + nLinhasEdit);

        // Atualizar o Singleton após a alteração
        if (nLinhasEdit > 0) {
            SingletonGestorProdutos.getInstance(context).setUtilizador(utilizador);
        }

        return nLinhasEdit > 0;
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
                TABLE_NAME,
                new String[]{USERNAME},
                ID + " = ?",
                new String[]{String.valueOf(userId)},
                null,
                null,
                null
        );

        try {
            if (cursor != null && cursor.moveToFirst()) {
                int columnIndex = cursor.getColumnIndex(USERNAME);

                if (columnIndex != -1) {
                    username = cursor.getString(columnIndex);
                } else {
                    Log.e("TAG", "getUsernameById: " + "username column not found");
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
