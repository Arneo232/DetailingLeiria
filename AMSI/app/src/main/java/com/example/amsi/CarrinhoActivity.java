package com.example.amsi;

import android.os.Bundle;
import androidx.appcompat.app.AppCompatActivity;
import android.widget.ArrayAdapter;
import android.widget.Spinner;
import android.content.Context;
import android.content.SharedPreferences;
import android.widget.TextView;
import android.widget.Button;
import android.widget.Toast;

import com.example.amsi.listeners.MetodoEntregaListener;
import com.example.amsi.listeners.MetodoPagamentoListener;
import com.example.amsi.modelo.MetodoEntrega;
import com.example.amsi.modelo.MetodoPagamento;
import com.example.amsi.modelo.SingletonGestorProdutos;

import java.util.ArrayList;
import java.util.List;

public class CarrinhoActivity extends AppCompatActivity implements MetodoEntregaListener, MetodoPagamentoListener {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_carrinho);

        // Recuperar os dados armazenados nas SharedPreferences
        SharedPreferences sharedPreferences = getSharedPreferences("UserPreferences", Context.MODE_PRIVATE);
        String email = sharedPreferences.getString("email", "Email não disponível");
        String nome = sharedPreferences.getString("nome", "Nome não disponível");
        String telefone = sharedPreferences.getString("telefone", "Telefone não disponível");
        String morada = sharedPreferences.getString("morada", "Morada não disponível");

        // Obter as referências dos TextViews
        TextView tvEmail = findViewById(R.id.tvEmail);
        TextView tvNome = findViewById(R.id.tvNome);
        TextView tvTelefone = findViewById(R.id.tvTelefone);
        TextView tvMorada = findViewById(R.id.tvMorada);

        // Atualizar os TextViews com os dados recuperados
        tvEmail.setText("E-mail: " + email);
        tvNome.setText("Nome: " + nome);
        tvTelefone.setText("Telefone: " + telefone);
        tvMorada.setText("Morada: " + morada);

        // Referências aos spinners e botão
        Spinner spinnerMetodoEntrega = findViewById(R.id.spinnerMetodoEntrega);
        Spinner spinnerMetodoPagamento = findViewById(R.id.spinnerMetodoPagamento);
        Button btnConfirmarCompra = findViewById(R.id.btnConfirmarCompra);

        // Configurar listeners para obter os métodos de entrega e pagamento
        SingletonGestorProdutos gestorProdutos = SingletonGestorProdutos.getInstance(this);
        gestorProdutos.setMetodoEntregaListener(this);
        gestorProdutos.setMetodoPagamentoListener(this);

        // Obter os métodos de entrega e pagamento da API
        gestorProdutos.getMetodosEntregaAPI(this);
        gestorProdutos.getMetodosPagamentoAPI(this);

        // Ação do botão de confirmar compra
        btnConfirmarCompra.setOnClickListener(view -> {
            if (spinnerMetodoEntrega.getSelectedItem() == null || spinnerMetodoPagamento.getSelectedItem() == null) {
                Toast.makeText(this, "Selecione todos os métodos para prosseguir.", Toast.LENGTH_SHORT).show();
                return;
            }

            // Adicionar aqui a lógica para finalizar a compra
            Toast.makeText(this, "Compra finalizada com sucesso!", Toast.LENGTH_SHORT).show();
        });
    }

    @Override
    public void onMetodosEntregaObtidos(List<MetodoEntrega> metodosEntrega) {
        // Preencher o Spinner com os métodos de entrega obtidos
        Spinner spinnerMetodoEntrega = findViewById(R.id.spinnerMetodoEntrega);
        List<String> nomesEntrega = new ArrayList<>();
        for (MetodoEntrega metodo : metodosEntrega) {
            nomesEntrega.add(metodo.getDesignacao());
        }
        ArrayAdapter<String> entregaAdapter = new ArrayAdapter<>(this, android.R.layout.simple_spinner_item, nomesEntrega);
        entregaAdapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
        spinnerMetodoEntrega.setAdapter(entregaAdapter);
    }

    @Override
    public void onMetodosPagamentoObtidos(List<MetodoPagamento> metodosPagamento) {
        // Preencher o Spinner com os métodos de pagamento obtidos
        Spinner spinnerMetodoPagamento = findViewById(R.id.spinnerMetodoPagamento);
        List<String> nomesPagamento = new ArrayList<>();
        for (MetodoPagamento metodo : metodosPagamento) {
            nomesPagamento.add(metodo.getDesignacao());
        }
        ArrayAdapter<String> pagamentoAdapter = new ArrayAdapter<>(this, android.R.layout.simple_spinner_item, nomesPagamento);
        pagamentoAdapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
        spinnerMetodoPagamento.setAdapter(pagamentoAdapter);
    }
}
