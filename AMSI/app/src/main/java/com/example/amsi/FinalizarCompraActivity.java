package com.example.amsi;

import android.content.SharedPreferences;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.TextView;
import android.widget.Toast;

import androidx.appcompat.app.AppCompatActivity;

import com.example.amsi.listeners.CarrinhoListener;
import com.example.amsi.modelo.LinhasCarrinho;
import com.example.amsi.modelo.SingletonGestorProdutos;

import java.util.ArrayList;

public class FinalizarCompraActivity extends AppCompatActivity implements CarrinhoListener {
    private Button btnFinalizar;
    private TextView tvTotal;
    private int idCarrinho;
    private int idMetodoEntrega = 1;
    private int idMetodoPagamento = 1;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_finalizar_compra);
        setTitle("Finalizar Compra");

        btnFinalizar = findViewById(R.id.btnFinalizar);
        tvTotal = findViewById(R.id.tvTotal);

        // Set listener for cart updates
        SingletonGestorProdutos.getInstance(this).setCarrinhoListener(this);

        // Fetch cart details from API
        SingletonGestorProdutos.getInstance(this).getCarrinhoAPI(this);

        btnFinalizar.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                finalizarCompra();
            }
        });
    }

    @Override
    public void onCarrinhoLoaded(String total, int fetchedIdCarrinho) {
        this.idCarrinho = fetchedIdCarrinho;
        tvTotal.setText(total + "€");
    }

    private void finalizarCompra() {
        if (idCarrinho == 0) {
            Toast.makeText(this, "Erro: Carrinho não encontrado!", Toast.LENGTH_SHORT).show();
            return;
        }
        if (tvTotal.getText().toString().equals("0€") || tvTotal.getText().toString().equals("0.00€")) {
            Toast.makeText(this, "O carrinho está vazio!", Toast.LENGTH_SHORT).show();
            return;
        }

        SingletonGestorProdutos.getInstance(this).finalizarCompraAPI(
                this,
                idCarrinho,
                idMetodoEntrega,
                idMetodoPagamento
        );
    }
}