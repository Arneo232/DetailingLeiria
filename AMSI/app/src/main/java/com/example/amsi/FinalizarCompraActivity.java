package com.example.amsi;

import android.os.Bundle;
import android.util.Log;
import android.view.MenuItem;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.Spinner;
import android.widget.TextView;
import android.widget.Toast;

import androidx.appcompat.app.AppCompatActivity;

import com.example.amsi.listeners.CarrinhoListener;
import com.example.amsi.listeners.MetodoEntregaListener;
import com.example.amsi.listeners.MetodoPagamentoListener;
import com.example.amsi.modelo.MetodoEntrega;
import com.example.amsi.modelo.MetodoPagamento;
import com.example.amsi.modelo.SingletonGestorProdutos;

import java.util.List;

public class FinalizarCompraActivity extends AppCompatActivity implements CarrinhoListener, MetodoEntregaListener, MetodoPagamentoListener {
    private Button btnFinalizar;
    private TextView tvTotal;
    private Spinner spinnerMetodoEntrega;
    private Spinner spinnerMetodoPagamento;
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
        spinnerMetodoEntrega = findViewById(R.id.spinnerEntrega);
        spinnerMetodoPagamento = findViewById(R.id.spinnerPagamento);

        SingletonGestorProdutos.getInstance(this).setCarrinhoListener(this);
        SingletonGestorProdutos.getInstance(this).getCarrinhoAPI(this);
        SingletonGestorProdutos.getInstance(this).getMetodosEntregaAPI(this, this);
        SingletonGestorProdutos.getInstance(this).getMetodosPagamentoAPI(this, this);

        if (getSupportActionBar() != null) {
            getSupportActionBar().setDisplayHomeAsUpEnabled(true);
            getSupportActionBar().setTitle("Detailing Leiria");
        }

        btnFinalizar.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                finalizarCompra();
            }
        });

        spinnerMetodoEntrega.setOnItemSelectedListener(new AdapterView.OnItemSelectedListener() {
            @Override
            public void onItemSelected(AdapterView<?> parentView, View selectedItemView, int position, long id) {
                MetodoEntrega selectedMetodo = (MetodoEntrega) parentView.getItemAtPosition(position);
                idMetodoEntrega = selectedMetodo.getIdmetodoEntrega();
            }

            @Override
            public void onNothingSelected(AdapterView<?> parentView) {
                idMetodoEntrega = 1;
            }
        });

        spinnerMetodoPagamento.setOnItemSelectedListener(new AdapterView.OnItemSelectedListener() {
            @Override
            public void onItemSelected(AdapterView<?> parentView, View selectedItemView, int position, long id) {
                MetodoPagamento selectedPayment = (MetodoPagamento) parentView.getItemAtPosition(position);
                idMetodoPagamento = selectedPayment.getidMetodoPagamento();
            }

            @Override
            public void onNothingSelected(AdapterView<?> parentView) {
                idMetodoPagamento = 1;
            }
        });
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        if (item.getItemId() == android.R.id.home) {

            finish();
            return true;
        }
        return super.onOptionsItemSelected(item);
    }

    @Override
    public void onCarrinhoLoaded(String total, int fetchedIdCarrinho) {
        this.idCarrinho = fetchedIdCarrinho;
        tvTotal.setText(total + "€");
    }

    @Override
    public void onMetodosEntregaObtidos(List<MetodoEntrega> metodosEntrega) {
        ArrayAdapter<MetodoEntrega> adapter = new ArrayAdapter<>(FinalizarCompraActivity.this, android.R.layout.simple_spinner_item, metodosEntrega);
        adapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
        spinnerMetodoEntrega.setAdapter(adapter);
    }

    @Override
    public void onMetodosPagamentoObtidos(List<MetodoPagamento> metodosPagamento) {
        Log.d("API_RESPONSE", "Payment Methods: " + metodosPagamento.size());

        if (metodosPagamento != null && !metodosPagamento.isEmpty()) {
            ArrayAdapter<MetodoPagamento> adapter = new ArrayAdapter<>(FinalizarCompraActivity.this, android.R.layout.simple_spinner_item, metodosPagamento);
            adapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
            spinnerMetodoPagamento.setAdapter(adapter);
        } else {
            Toast.makeText(FinalizarCompraActivity.this, "Nenhum método de pagamento disponível", Toast.LENGTH_SHORT).show();
        }
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
