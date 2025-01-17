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
import com.example.amsi.modelo.Produto;
import com.example.amsi.modelo.SingletonGestorProdutos;

import org.json.JSONException;

public class DetalheProdutoActivity extends AppCompatActivity {

    private ImageView imgProduto;
    private TextView tvNomeProduto, tvPrecoProduto, tvDetalhes;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_detalhe_produto);

        // Inicializar elementos da UI
        imgProduto = findViewById(R.id.imgProduto);
        tvNomeProduto = findViewById(R.id.tvNomeProduto);
        tvPrecoProduto = findViewById(R.id.tvPrecoProduto);
        tvDetalhes = findViewById(R.id.tvDetalhes);

        // Obter ID do produto do Intent
        int produtoId = getIntent().getIntExtra("produto_id", -1);

        if (produtoId != -1) {
            // Método para buscar os detalhes do produto
            fetchProdutoDetalhes(produtoId);
        } else {
            Toast.makeText(this, "Produto não encontrado.", Toast.LENGTH_SHORT).show();
            finish(); // Fechar a atividade se o ID for inválido
        }
    }

    private void fetchProdutoDetalhes(int produtoId) {
        // URL da API para buscar os detalhes do produto
        String url = "http://172.22.21.201/DetailingLeiria/DtlgLeiWebApp/backend/web/api/produtos" + produtoId;

        // Criar uma fila de requisições
        RequestQueue queue = Volley.newRequestQueue(this);

        // Criar a requisição para a API
        JsonObjectRequest request = new JsonObjectRequest(Request.Method.GET, url, null,
                response -> {
                    try {
                        // Parse dos dados recebidos da API
                        String nome = response.getString("nome");
                        String preco = String.format("%.2f €", response.getDouble("preco"));
                        String detalhes = response.getString("descricao");
                        String imagemUrl = response.getString("imagemUrl");

                        // Atualizar os dados na UI
                        tvNomeProduto.setText(nome);
                        tvPrecoProduto.setText(preco);
                        tvDetalhes.setText(detalhes);

                        // Carregar a imagem dinamicamente
                        Glide.with(this).load(imagemUrl).into(imgProduto);

                    } catch (JSONException e) {
                        e.printStackTrace();
                        Toast.makeText(this, "Erro ao processar os detalhes do produto.", Toast.LENGTH_SHORT).show();
                    }
                },
                error -> {
                    // Lidar com erros de requisição
                    Toast.makeText(this, "Erro ao carregar detalhes do produto.", Toast.LENGTH_SHORT).show();
                });

        // Adicionar a requisição à fila
        queue.add(request);
    }
}