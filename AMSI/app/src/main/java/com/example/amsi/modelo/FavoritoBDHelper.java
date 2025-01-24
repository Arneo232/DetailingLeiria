package com.example.amsi.modelo;

import android.content.Context;
import android.content.SharedPreferences;
import android.database.Cursor;
import android.database.sqlite.SQLiteDatabase;
import android.database.sqlite.SQLiteOpenHelper;
import android.util.Log;

import java.util.ArrayList;

public class FavoritoBDHelper extends SQLiteOpenHelper {
    private static final String DBNAME = "detailingleiria";
    private static final String TABLE_NAME = "favoritos";
    private static final int DB_VERSION = 1;

    private static final String IDFAVORITO = "idfavorito";
    private static final String IDPRODUTO = "idproduto";
    private static final String IDPROFILE = "idprofile";
    private static final String NOME = "nome";
    private static final String PRECO = "preco";
    private static final String IMAGEM = "imagem";

    private SQLiteDatabase favoritosDB;

    public FavoritoBDHelper(Context context) {
        super(context, DBNAME, null, DB_VERSION);
        favoritosDB = getWritableDatabase();
    }

    @Override
    public void onCreate(SQLiteDatabase db) {
        String sql = "CREATE TABLE " + TABLE_NAME + " (" +
                IDFAVORITO + " INTEGER PRIMARY KEY AUTOINCREMENT, " +
                IDPRODUTO + " INTEGER, " +
                IDPROFILE + " INTEGER, " +
                NOME + " TEXT, " +
                PRECO + " REAL, " +
                IMAGEM + " TEXT" +
                ")";
        db.execSQL(sql);
    }

    @Override
    public void onUpgrade(SQLiteDatabase db, int oldVersion, int newVersion) {
        String sql = "DROP TABLE IF EXISTS " + TABLE_NAME;
        db.execSQL(sql);
        onCreate(db);
    }

    /**
     * Get all favoritos for the last logged-in user by idprofile from SharedPreferences.
     */
    public ArrayList<Favorito> getFavoritosBD(Context context) {
        ArrayList<Favorito> favoritos = new ArrayList<>();
        SharedPreferences sharedPreferences = context.getSharedPreferences("AppPreferences", Context.MODE_PRIVATE);
        int idprofile = sharedPreferences.getInt("idprofile",  -1);

        Log.d("FavoritoBDHelper", "Fetching favoritos for idprofile: " + idprofile);

        Cursor cursor = this.favoritosDB.query(TABLE_NAME, new String[]{IDFAVORITO, IDPRODUTO, IDPROFILE, NOME, PRECO, IMAGEM},
                IDPROFILE + " = ?", new String[]{String.valueOf(idprofile)}, null, null, null);

        if (cursor != null) {
            Log.d("FavoritoBDHelper", "Cursor count: " + cursor.getCount());
            if (cursor.moveToFirst()) {
                do {
                    Favorito auxFavorito = new Favorito(
                            cursor.getInt(0),
                            cursor.getInt(1),
                            cursor.getInt(2),
                            cursor.getString(3),
                            cursor.getDouble(4),
                            cursor.getString(5)
                    );
                    favoritos.add(auxFavorito);
                } while (cursor.moveToNext());
            }
            cursor.close();
        }

        Log.d("FavoritoBDHelper", "Fetched favoritos count: " + favoritos.size());
        return favoritos;
    }
}