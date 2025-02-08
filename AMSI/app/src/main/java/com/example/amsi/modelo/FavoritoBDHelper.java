package com.example.amsi.modelo;

import android.content.ContentValues;
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
    private static final int DB_VERSION = 2;

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

    public void removerTodosFavoritos() {
        SQLiteDatabase db = this.getWritableDatabase();
        int deletedRows = db.delete("favoritos", null, null);
        Log.d("DB_DELETE", "Favoritos removidos: " + deletedRows);
        db.close();
    }

    public void adicionarFavorito(Favorito favorito) {
        SQLiteDatabase db = this.getWritableDatabase();
        ContentValues values = new ContentValues();

        values.put("idfavorito", favorito.getIdfavorito());
        values.put("idprofile", favorito.getIdprofile());
        values.put("idproduto", favorito.getIdproduto());
        values.put("nome", favorito.getNome());
        values.put("preco", favorito.getPreco());
        values.put("imagem", favorito.getImagem());

        long result = db.insert("favoritos", null, values);
        if (result == -1) {
            Log.e("DB_INSERT", "Erro ao inserir favorito ID: " + favorito.getIdfavorito());
        } else {
            Log.d("DB_INSERT", "Favorito inserido ID: " + favorito.getIdfavorito());
        }

        db.close();
    }

    public void removerFavoritoBD(int id) {
        int delete = this.favoritosDB.delete(TABLE_NAME, IDFAVORITO + "=?", new String[]{id + ""});
    }

    public ArrayList<Favorito> getFavoritosBD() {

        ArrayList<Favorito> favoritos = new ArrayList<>();
        Cursor cursor = favoritosDB.query(TABLE_NAME, new String[]{IDFAVORITO, IDPRODUTO, IDPROFILE, NOME, PRECO, IMAGEM},
                null, null, null, null, null);

        Log.d("FavoritoBDHelper", "Cursor count: " + cursor.getCount());

        if (cursor.moveToFirst()) {
            do {
                Favorito auxFavorito = new Favorito(
                        cursor.getInt(0),
                        cursor.getInt(1),
                        cursor.getInt(2),
                        cursor.getString(3),
                        cursor.getFloat(4),
                        cursor.getString(5)
                );
                favoritos.add(auxFavorito);
            } while (cursor.moveToNext());
        }
        cursor.close();

        Log.d("FavoritoBDHelper", "Fetched favoritos count: " + favoritos.size());
        return favoritos;
    }
}