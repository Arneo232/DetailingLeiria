package com.example.amsi;

import android.os.Bundle;
import android.view.Menu;
import android.view.MenuInflater;
import android.view.MenuItem;
import android.widget.AdapterView;
import android.widget.ListView;
import android.widget.SearchView;
import android.widget.Toast;

import androidx.appcompat.app.AppCompatActivity;

import com.example.amsi.adaptadores.ListaProdutosAdaptador;
import com.example.amsi.listeners.ProdutosListener;
import com.example.amsi.modelo.Produto;
import com.example.amsi.modelo.SingletonGestorProdutos;

import java.util.ArrayList;

public class LojaActivity extends AppCompatActivity implements ProdutosListener {

    private ListView lvProdutos;
    private ArrayList<Produto> produtos;
    private SearchView searchView;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_loja);

        lvProdutos = findViewById(R.id.lvProdutos);
        SingletonGestorProdutos.getInstance(getApplicationContext()).setProdutosListener(this);
        SingletonGestorProdutos.getInstance(getApplicationContext()).getAllProdutosAPI(getApplicationContext());

        // Clique no item da lista
        lvProdutos.setOnItemClickListener((adapterView, view, position, id) -> {
            // Ação ao clicar no produto
            // Aqui podemos passar o produto clicado para a tela de detalhes, por exemplo.
            // Por exemplo:
            // Intent intent = new Intent(LojaActivity.this, DetalhesProdutoActivity.class);
            // intent.putExtra("ID_PRODUTO", (int) id);
            // startActivity(intent);
            Toast.makeText(LojaActivity.this, "Produto Selecionado: " + id, Toast.LENGTH_SHORT).show();
        });
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        MenuInflater inflater = getMenuInflater();
        inflater.inflate(R.menu.menu_pesquisa, menu);

        MenuItem itemPesquisa = menu.findItem(R.id.itemPesquisa);
        searchView = (SearchView) itemPesquisa.getActionView();

        searchView.setOnQueryTextListener(new SearchView.OnQueryTextListener() {
            @Override
            public boolean onQueryTextSubmit(String query) {
                return false;
            }

            @Override
            public boolean onQueryTextChange(String newText) {
                ArrayList<Produto> tempListaProdutos = new ArrayList<>();
                for (Produto produto : SingletonGestorProdutos.getInstance(getApplicationContext()).getProdutosBD()) {
                    if (produto.getNome().toLowerCase().contains(newText.toLowerCase())) {
                        tempListaProdutos.add(produto);
                    }
                }
                lvProdutos.setAdapter(new ListaProdutosAdaptador(getApplicationContext(), tempListaProdutos));
                return true;
            }
        });

        return true;
    }

    @Override
    public void onRefreshListaProdutos(ArrayList<Produto> listaProdutos) {
        if (listaProdutos != null) {
            lvProdutos.setAdapter(new ListaProdutosAdaptador(this, listaProdutos));
        }
    }
}
