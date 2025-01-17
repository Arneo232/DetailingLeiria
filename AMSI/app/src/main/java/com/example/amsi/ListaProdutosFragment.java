package com.example.amsi;

import android.content.Intent;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.AdapterView;
import android.widget.ListView;
import android.widget.SearchView;

import androidx.fragment.app.Fragment;

import com.example.amsi.adaptadores.ListaProdutosAdaptador;
import com.example.amsi.listeners.ProdutosListener;
import com.example.amsi.modelo.Produto;
import com.example.amsi.modelo.SingletonGestorProdutos;
import com.google.android.material.floatingactionbutton.FloatingActionButton;

import java.util.ArrayList;

public class ListaProdutosFragment extends Fragment implements ProdutosListener {
    private ListView lvProdutos; //objeto gráfico
    private ArrayList<Produto> produtos;

    private FloatingActionButton fabLista;
    private SearchView searchView;

    public ListaProdutosFragment() {
        // Required empty public constructor
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
        // Inflate o layout para este fragmento
        View view = inflater.inflate(R.layout.fragment_lista_produtos, container, false);
        setHasOptionsMenu(true);

        // Inicializar o ListView e configurar o listener
        lvProdutos = view.findViewById(R.id.lvProdutos);

        // Configurar o listener para quando os produtos forem carregados
        SingletonGestorProdutos.getInstance(getContext()).setProdutosListener(this);
        SingletonGestorProdutos.getInstance(getContext()).getAllProdutosAPI(getContext());

        // Configurar o clique nos itens da lista
        lvProdutos.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> adapterView, View view, int position, long id) {
                // Obter o produto correspondente ao clique
                Produto produtoSelecionado = (Produto) adapterView.getItemAtPosition(position);

                // Criar uma Intent para abrir a DetalheProdutoActivity
                Intent intent = new Intent(getContext(), DetalheProdutoActivity.class);
                intent.putExtra("produto_id", produtoSelecionado.getIdProduto()); // Enviar o ID do produto
                startActivity(intent);
            }
        });

        return view;
    }

    @Override
    public void onRefreshListaProdutos(ArrayList<Produto> listaProdutos) {
        if (listaProdutos != null) {
            // Atualizar o adaptador do ListView com a lista de produtos
            lvProdutos.setAdapter(new ListaProdutosAdaptador(getContext(), listaProdutos));
        }
    }

}