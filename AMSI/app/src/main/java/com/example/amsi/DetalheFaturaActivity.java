package com.example.amsi;

import android.os.Bundle;
import android.util.Log;
import android.widget.ListView;
import androidx.appcompat.app.AppCompatActivity;

import com.example.amsi.adaptadores.ListaLinhasFaturaAdaptador;
import com.example.amsi.listeners.FaturaListener;
import com.example.amsi.modelo.LinhasFatura;
import com.example.amsi.modelo.SingletonGestorProdutos;

import java.util.ArrayList;

public class DetalheFaturaActivity extends AppCompatActivity implements FaturaListener {
    public static final String IDFATURA = "idvenda";
    private int idFatura;
    private ArrayList<LinhasFatura> linhasFaturaList;
    private ListView lvLinhasFatura;
    private ListaLinhasFaturaAdaptador adapter;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_detalhe_fatura);

        idFatura = getIntent().getIntExtra(IDFATURA, -1);

        lvLinhasFatura = findViewById(R.id.lvLinhasFatura);
        linhasFaturaList = new ArrayList<>();
        adapter = new ListaLinhasFaturaAdaptador(this, linhasFaturaList);
        lvLinhasFatura.setAdapter(adapter);

        SingletonGestorProdutos.getInstance(this).setFaturaListener(this);
        SingletonGestorProdutos.getInstance(this).getAllLinhasFaturaAPI(this, idFatura);
    }

    @Override
    public void onRefreshDetalhes(ArrayList<LinhasFatura> linhasFatura) {
        if (linhasFatura != null) {
            linhasFaturaList.clear();
            linhasFaturaList.addAll(linhasFatura);
            Log.d("ADAPTER", "Adapter updated with " + linhasFaturaList.size() + " items");

            runOnUiThread(() -> adapter.notifyDataSetChanged());
        }
    }
}
