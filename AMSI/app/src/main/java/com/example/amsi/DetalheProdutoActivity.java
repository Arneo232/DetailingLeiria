package com.example.amsi;

import android.os.Bundle;
import android.widget.ImageButton;
import android.widget.ImageView;
import android.widget.TextView;
import android.widget.Toast;

import androidx.appcompat.app.AppCompatActivity;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.toolbox.JsonObjectRequest;
import com.android.volley.toolbox.Volley;
import com.bumptech.glide.Glide;
import com.bumptech.glide.load.engine.DiskCacheStrategy;
import com.example.amsi.listeners.ProdutoListener;
import com.example.amsi.modelo.Produto;
import com.example.amsi.modelo.SingletonGestorProdutos;

import org.json.JSONException;

import android.widget.Button;

public class DetalheProdutoActivity extends AppCompatActivity implements ProdutoListener {
    private ImageView imgProduto;
    private TextView tvNomeProduto, tvPrecoProduto, tvDetalhes;
    private Produto produto;
    private ImageButton btnFavorito; // Add a reference to the button
    public static final String IDPRODUTO = "idProduto";

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_detalhe_produto);
        setTitle("Detalhes do produto");
        imgProduto = findViewById(R.id.imgProduto);
        tvNomeProduto = findViewById(R.id.tvNomeProduto);
        tvPrecoProduto = findViewById(R.id.tvPrecoProduto);
        tvDetalhes = findViewById(R.id.tvDetalhes);
        btnFavorito = findViewById(R.id.btnFavorito); // Initialize the button

        SingletonGestorProdutos.getInstance(this).setProdutoListener(this);
        produto = SingletonGestorProdutos.getInstance(this).getProdutoAPI(this, getIntent().getIntExtra(IDPRODUTO, 0));

        if (produto != null) {
            buscaInfo();
        }

        // Set up the button to handle adding to favorites
        btnFavorito.setOnClickListener(v -> addProdutoToFavoritos());
    }

    private void addProdutoToFavoritos() {
        if (produto != null) {
            SingletonGestorProdutos.getInstance(this).addFavoritoAPI(this, produto.getIdProduto());
        } else {
            Toast.makeText(this, "Erro: Produto não encontrado!", Toast.LENGTH_SHORT).show();
        }
    }

    public void buscaInfo() {
        tvNomeProduto.setText(produto.getNome());
        tvPrecoProduto.setText(String.format("€ %.2f", produto.getPreco()));
        tvDetalhes.setText(produto.getDescricao());
        Glide.with(this)
                .load(produto.getImgProduto())
                .placeholder(R.drawable.dl_logo)
                .diskCacheStrategy(DiskCacheStrategy.ALL)
                .into(imgProduto);
    }

    @Override
    public void onRefreshDetalhes(Produto produto) {
        this.produto = produto;
        buscaInfo();
    }
}
