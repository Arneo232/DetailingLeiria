package com.example.amsi;

import android.os.Bundle;
import android.view.View;
import android.widget.Button;

import androidx.activity.EdgeToEdge;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.graphics.Insets;
import androidx.core.view.ViewCompat;
import androidx.core.view.WindowInsetsCompat;

import com.example.amsi.modelo.SingletonGestorProdutos;

public class FinalizarCompraActivity extends AppCompatActivity {
    private Button btnFinalizar;
    private int idCarrinho = 31;
    private int idMetodoEntrega = 1;
    private int idMetodoPagamento = 1;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_finalizar_compra);
        setTitle("Finalizar Compra");

        btnFinalizar = findViewById(R.id.btnFinalizar);

        btnFinalizar.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                finalizarCompra();
            }
        });
    }

    private void finalizarCompra() {
        SingletonGestorProdutos.getInstance(this).finalizarCompraAPI(
                this,
                idCarrinho,
                idMetodoEntrega,
                idMetodoPagamento
        );
    }
}