package com.example.amsi.modelo;

import android.content.ContentValues;
import android.content.Context;
import android.database.Cursor;
import android.database.sqlite.SQLiteDatabase;
import android.database.sqlite.SQLiteOpenHelper;

import androidx.annotation.Nullable;

import java.util.ArrayList;

public class ProdutoBDHelper extends SQLiteOpenHelper {

    private static final String DB_NAME = "detailing_leiria";
    private static final String TABLE_NAME = "produtos";
    private static final String TABLE_MY_PRODUTOS = "meus_produtos";
    private static final int DB_VERSION = 1;

    private SQLiteDatabase db;

    private static final String ID = "idProduto";
    private static final String NOME = "nome";
    private static final String DESCRICAO = "descricao";
    private static final String PRECO = "preco";
    private static final String STOCK = "stock";
    private static final String IDCATEGORIA = "idCategoria";
    private static final String FORNECEDORES_ID = "fornecedoresId";
    private static final String IDDESCONTO = "idDesconto";

    public ProdutoBDHelper(@Nullable Context context) {
        super(context, DB_NAME, null, DB_VERSION);
        db = getWritableDatabase();
    }

    public void removerAllProdutosBD() {
        db.delete(TABLE_NAME, null, null);
    }

    public void removerAllMeusProdutosBD() {
        db.delete(TABLE_MY_PRODUTOS, null, null);
    }

    public ArrayList<Produto> getAllProdutosBD() {
        ArrayList<Produto> produtos = new ArrayList<>();

        Cursor cursor = db.query(TABLE_NAME,
                new String[]{ID, NOME, DESCRICAO, PRECO, STOCK, IDCATEGORIA, FORNECEDORES_ID, IDDESCONTO},
                null, null, null, null, null);

        if (cursor.moveToFirst()) {
            do {
                Produto auxProduto = new Produto(
                        cursor.getInt(0), // idProduto
                        cursor.getString(1), // nome
                        cursor.getString(2), // descricao
                        cursor.getDouble(3), // preco
                        cursor.getInt(4), // stock
                        cursor.getInt(5), // idCategoria
                        cursor.getInt(6), // fornecedoresId
                        cursor.getInt(7) // idDesconto
                );
                produtos.add(auxProduto);
            } while (cursor.moveToNext());
            cursor.close();
        }
        return produtos;
    }

    public ArrayList<Produto> getAllMeusProdutosBD() {
        ArrayList<Produto> produtos = new ArrayList<>();

        Cursor cursor = db.query(TABLE_MY_PRODUTOS,
                new String[]{ID, NOME, DESCRICAO, PRECO, STOCK, IDCATEGORIA, FORNECEDORES_ID, IDDESCONTO},
                null, null, null, null, null);

        if (cursor.moveToFirst()) {
            do {
                Produto auxProduto = new Produto(
                        cursor.getInt(0), // idProduto
                        cursor.getString(1), // nome
                        cursor.getString(2), // descricao
                        cursor.getDouble(3), // preco
                        cursor.getInt(4), // stock
                        cursor.getInt(5), // idCategoria
                        cursor.getInt(6), // fornecedoresId
                        cursor.getInt(7) // idDesconto
                );
                produtos.add(auxProduto);
            } while (cursor.moveToNext());
            cursor.close();
        }
        return produtos;
    }

    @Override
    public void onCreate(SQLiteDatabase sqLiteDatabase) {
        String sqlTableProdutos = "CREATE TABLE " + TABLE_NAME + "(" +
                ID + " INTEGER PRIMARY KEY, " +
                NOME + " TEXT NOT NULL, " +
                DESCRICAO + " TEXT NOT NULL, " +
                PRECO + " REAL NOT NULL, " +
                STOCK + " INTEGER NOT NULL, " +
                IDCATEGORIA + " INTEGER NOT NULL, " +
                FORNECEDORES_ID + " INTEGER NOT NULL, " +
                IDDESCONTO + " INTEGER NOT NULL" +
                ");";
        sqLiteDatabase.execSQL(sqlTableProdutos);

        String sqlTableMeusProdutos = "CREATE TABLE " + TABLE_MY_PRODUTOS + "(" +
                ID + " INTEGER PRIMARY KEY, " +
                NOME + " TEXT NOT NULL, " +
                DESCRICAO + " TEXT NOT NULL, " +
                PRECO + " REAL NOT NULL, " +
                STOCK + " INTEGER NOT NULL, " +
                IDCATEGORIA + " INTEGER NOT NULL, " +
                FORNECEDORES_ID + " INTEGER NOT NULL, " +
                IDDESCONTO + " INTEGER NOT NULL" +
                ");";
        sqLiteDatabase.execSQL(sqlTableMeusProdutos);
    }

    @Override
    public void onUpgrade(SQLiteDatabase sqLiteDatabase, int oldVersion, int newVersion) {
        sqLiteDatabase.execSQL("DROP TABLE IF EXISTS " + TABLE_NAME);
        sqLiteDatabase.execSQL("DROP TABLE IF EXISTS " + TABLE_MY_PRODUTOS);
        onCreate(sqLiteDatabase);
    }

    public Produto adicionarProdutoBD(Produto produto) {
        ContentValues values = new ContentValues();
        values.put(ID, produto.getIdProduto());
        values.put(NOME, produto.getNome());
        values.put(DESCRICAO, produto.getDescricao());
        values.put(PRECO, produto.getPreco());
        values.put(STOCK, produto.getStock());
        values.put(IDCATEGORIA, produto.getIdCategoria());
        values.put(FORNECEDORES_ID, produto.getFornecedoresId());
        values.put(IDDESCONTO, produto.getIdDesconto());
        db.insert(TABLE_NAME, null, values);
        return produto;
    }

    public Produto adicionarMeuProdutoBD(Produto produto) {
        ContentValues values = new ContentValues();
        values.put(ID, produto.getIdProduto());
        values.put(NOME, produto.getNome());
        values.put(DESCRICAO, produto.getDescricao());
        values.put(PRECO, produto.getPreco());
        values.put(STOCK, produto.getStock());
        values.put(IDCATEGORIA, produto.getIdCategoria());
        values.put(FORNECEDORES_ID, produto.getFornecedoresId());
        values.put(IDDESCONTO, produto.getIdDesconto());
        db.insert(TABLE_MY_PRODUTOS, null, values);
        return produto;
    }
}
