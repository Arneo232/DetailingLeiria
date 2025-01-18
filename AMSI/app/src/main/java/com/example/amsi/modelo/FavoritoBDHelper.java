package com.example.amsi.modelo;

import android.content.ContentValues;
import android.content.Context;
import android.database.Cursor;
import android.database.sqlite.SQLiteDatabase;
import android.database.sqlite.SQLiteOpenHelper;

import java.util.ArrayList;

public class FavoritoBDHelper extends SQLiteOpenHelper {
    private static final String DBNAME = "detailingleiria", TABLE_NAME = "favoritos";
    private static final int DB_VERSION = 1;
    private static final String FAVORITOS="favoritos";
    private SQLiteDatabase db;

    private static final String IDFAVORITO = "idfavorito",
            IDPRODUTO = "idproduto",
            IDPROFILE = "idprofile",
            NOME = "nome",
            PRECO = "preco",
            IMAGEM = "imagem";

    public FavoritoBDHelper(Context context) {
        super(context, DBNAME, null, DB_VERSION);
        db = getWritableDatabase();
    }

    public ArrayList<Favorito> getAllFavoritos(){
        ArrayList<Favorito> favorito = new ArrayList<>();

        Cursor cursor = db.query(TABLE_NAME, new String[]{IDFAVORITO, IDPRODUTO, IDPROFILE, NOME, PRECO, IMAGEM}, null, null, null, null, null);

        if(cursor.moveToFirst()){
            do{
                Favorito aux = new Favorito(
                        cursor.getInt(0),    // IDFAVORITO
                        cursor.getInt(1),    // IDPRODUTO
                        cursor.getInt(2),    // IDPROFILE
                        cursor.getString(3), // NOME
                        cursor.getFloat(4), // PRECO
                        cursor.getString(5)  // IMAGEM
                );
                favorito.add(aux);
            }while(cursor.moveToNext());
            cursor.close();
        }
        return favorito;
    }

    @Override
    public void onCreate(SQLiteDatabase db) {
        String sql = "CREATE TABLE " + TABLE_NAME + "(" +
                IDFAVORITO + " INTEGER, " +
                IDPRODUTO + " INTEGER, " +
                IDPROFILE + " INTEGER, " +
                NOME + " TEXT, " +
                PRECO + " REAL," +
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

    public ArrayList<Favorito> getAllFavoritosBD(){
        ArrayList<Favorito> favoritos = new ArrayList<>();
        Cursor cursor = this.db.query(FAVORITOS, new String[]{IDFAVORITO, IDPRODUTO, IDPROFILE, NOME, PRECO, IMAGEM}, null, null, null, null, null);
        if(cursor.moveToFirst()){
            do{
                Favorito auxFavorito = new Favorito(cursor.getInt(0), cursor.getInt(1), cursor.getInt(2), cursor.getString(3), cursor.getDouble(4), cursor.getString(5));
                favoritos.add(auxFavorito);
            }while(cursor.moveToNext());
            cursor.close();
        }
        return favoritos;
    }

    public void adicionarFavoritoBD(Favorito favorito){
        ContentValues values = new ContentValues();
        values.put(IDPROFILE, favorito.getIdprofile());
        values.put(IDPRODUTO, favorito.getIdproduto());
        values.put(NOME, favorito.getNome());
        values.put(PRECO, favorito.getPreco());
        values.put(IMAGEM, favorito.getImagem());
        db.insert(TABLE_NAME, null, values);
    }

    public boolean removerFavoritoBD(int idfavorito){
        int numLinhasDel = this.db.delete(FAVORITOS, IDFAVORITO + "=?", new String[]{idfavorito+""});
        return numLinhasDel==1;
    }
}
