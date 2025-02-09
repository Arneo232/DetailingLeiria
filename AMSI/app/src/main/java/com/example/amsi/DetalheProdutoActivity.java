package com.example.amsi;

import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.MenuItem;
import android.view.View;
import android.widget.EditText;
import android.widget.ImageButton;
import android.widget.ImageView;
import android.widget.ListView;
import android.widget.RatingBar;
import android.widget.TextView;
import android.widget.Toast;

import androidx.appcompat.app.AlertDialog;
import androidx.appcompat.app.AppCompatActivity;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.toolbox.JsonObjectRequest;
import com.android.volley.toolbox.Volley;
import com.bumptech.glide.Glide;
import com.bumptech.glide.load.engine.DiskCacheStrategy;
import com.example.amsi.adaptadores.ListaAvaliacoesAdaptador;
import com.example.amsi.listeners.AvaliacoesListener;
import com.example.amsi.listeners.ProdutoListener;
import com.example.amsi.listeners.VerificaFavoritoListener;
import com.example.amsi.modelo.Avaliacao;
import com.example.amsi.modelo.Produto;
import com.example.amsi.modelo.SingletonGestorProdutos;

import org.json.JSONException;

import android.widget.Button;

import java.util.ArrayList;

public class DetalheProdutoActivity extends AppCompatActivity implements ProdutoListener, AvaliacoesListener, VerificaFavoritoListener {
    private ImageView imgProduto;
    private TextView tvNomeProduto, tvPrecoProduto, tvDetalhes;
    private Produto produto;
    private ImageButton btnFavorito;
    private Button btnAdicionarCarrinho, btnAvaliar;
    private ListView lvAvaliacoes;
    private ArrayList<Avaliacao> listaAvaliacoes;
    private ListaAvaliacoesAdaptador adaptador;

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
        btnFavorito = findViewById(R.id.btnFavorito);
        btnAdicionarCarrinho = findViewById(R.id.btnAdicionarCarrinho);
        lvAvaliacoes = findViewById(R.id.lvAvaliacoes);
        btnAvaliar = findViewById(R.id.btnAvaliar);

        listaAvaliacoes = new ArrayList<>();
        adaptador = new ListaAvaliacoesAdaptador(this, listaAvaliacoes);
        lvAvaliacoes.setAdapter(adaptador);

        SingletonGestorProdutos.getInstance(this).setProdutoListener(this);
        SingletonGestorProdutos.getInstance(this).setAvaliacoesListener(this);
        SingletonGestorProdutos.getInstance(this).setVerificaFavoritoListener(this);

        produto = SingletonGestorProdutos.getInstance(this).getProdutoAPI(this, getIntent().getIntExtra(IDPRODUTO, 0));

        if (produto != null) {
            buscaInfo();
        }

        if (getSupportActionBar() != null) {
            getSupportActionBar().setDisplayHomeAsUpEnabled(true);
        }

        int idProduto = getIntent().getIntExtra(IDPRODUTO, 0);
        SingletonGestorProdutos.getInstance(this).getAllAvaliacoesAPI(this, idProduto);

        SingletonGestorProdutos.getInstance(this).verificaFavAPI(this, idProduto);

        btnFavorito.setOnClickListener(v -> addProdutoToFavoritos());

        btnAdicionarCarrinho.setOnClickListener(v -> addProdutoToCarrinho());

        btnAvaliar.setOnClickListener(v -> showAvaliacaoDialog(idProduto));
    }

    private void addProdutoToFavoritos() {
        if (produto != null) {
            SingletonGestorProdutos.getInstance(this).addFavoritoAPI(this, produto.getIdProduto());
            SingletonGestorProdutos.getInstance(this).verificaFavAPI(this, produto.getIdProduto());
        } else {
            Toast.makeText(this, "Erro: Produto não encontrado!", Toast.LENGTH_SHORT).show();
        }
    }

    private void addProdutoToCarrinho() {
        if (produto != null) {
            int quantidade = 1;
            SingletonGestorProdutos.getInstance(this).addLinhaCarrinhoAPI(this, produto.getIdProduto(), quantidade);
        } else {
            Toast.makeText(this, "Erro: Produto não encontrado!", Toast.LENGTH_SHORT).show();
        }
    }

    private void showAvaliacaoDialog(int idProduto) {
        LayoutInflater inflater = LayoutInflater.from(this);
        View view = inflater.inflate(R.layout.dialog_avaliacao, null);

        RatingBar ratingBar = view.findViewById(R.id.ratingBar);
        EditText editTextComentario = view.findViewById(R.id.editTextComentario);
        Button btnEnviarAvaliacao = view.findViewById(R.id.btnEnviarAvaliacao);

        AlertDialog.Builder builder = new AlertDialog.Builder(this);
        builder.setView(view);
        AlertDialog dialog = builder.create();

        btnEnviarAvaliacao.setOnClickListener(v -> {
            float rating = ratingBar.getRating();
            String comentario = editTextComentario.getText().toString().trim();

            if (rating == 0) {
                Toast.makeText(this, "Por favor, selecione uma nota!", Toast.LENGTH_SHORT).show();
                return;
            }

            if (comentario.isEmpty()) {
                Toast.makeText(this, "Por favor, escreva um comentário!", Toast.LENGTH_SHORT).show();
                return;
            }
            SingletonGestorProdutos.getInstance(this).fazerAvaliacaoAPI(this, idProduto, rating, comentario);
            dialog.dismiss();
        });
        dialog.show();
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

    @Override
    public void onRefreshAvaliacoes(ArrayList<Avaliacao> avaliacoes) {
        listaAvaliacoes.clear();
        listaAvaliacoes.addAll(avaliacoes);
        adaptador.notifyDataSetChanged();
    }

    @Override
    public void onVerificaFavorito(boolean isFavorito) {
        if (isFavorito) {
            btnFavorito.setImageResource(R.drawable.favorito_full);
        } else {
            btnFavorito.setImageResource(R.drawable.favorito);
        }
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        if (item.getItemId() == android.R.id.home) {

            finish();
            return true;
        }
        return super.onOptionsItemSelected(item);
    }
}
