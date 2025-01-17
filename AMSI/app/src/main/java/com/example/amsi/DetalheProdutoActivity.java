package com.example.amsi;

import android.os.Bundle;
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

public class DetalheProdutoActivity extends AppCompatActivity implements ProdutoListener {

    private ImageView imgProduto;
    private TextView tvNomeProduto, tvPrecoProduto, tvDetalhes;
    private Produto produto;
    public static final String IDPRODUTO = "idProduto";

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_detalhe_produto);

        imgProduto = findViewById(R.id.imgProduto);
        tvNomeProduto = findViewById(R.id.tvNomeProduto);
        tvPrecoProduto = findViewById(R.id.tvPrecoProduto);
        tvDetalhes = findViewById(R.id.tvDetalhes);

        SingletonGestorProdutos.getInstance(this).setProdutoListener(this);
        produto = SingletonGestorProdutos.getInstance(this).getProdutoAPI(this, getIntent().getIntExtra(IDPRODUTO, 0));
        if (produto != null){
            buscaInfo();
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