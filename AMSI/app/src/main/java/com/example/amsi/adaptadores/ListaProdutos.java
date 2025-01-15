package com.example.amsi.adaptadores;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.ImageView;
import android.widget.TextView;

import com.bumptech.glide.Glide;
import com.bumptech.glide.load.engine.DiskCacheStrategy;
import com.example.amsi.R;
import com.example.amsi.modelo.Produto;

import java.util.ArrayList;

public class ListaProdutosAdaptador extends BaseAdapter {

    private Context context;
    private LayoutInflater inflater;
    private ArrayList<Produto> produtos;

    public ListaProdutosAdaptador(Context context, ArrayList<Produto> produtos) {
        this.context = context;
        this.produtos = produtos;
    }

    @Override
    public int getCount() {
        return produtos.size();
    }

    @Override
    public Object getItem(int position) {
        return produtos.get(position);
    }

    @Override
    public long getItemId(int position) {
        return produtos.get(position).getIdProduto();
    }

    @Override
    public View getView(int position, View convertView, ViewGroup parent) {
        if (inflater == null) {
            inflater = (LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
        }
        if (convertView == null) {
            convertView = inflater.inflate(R.layout.item_lista_produto, null);
        }

        // Otimização com ViewHolder
        ViewHolderLista viewHolder = (ViewHolderLista) convertView.getTag();
        if (viewHolder == null) {
            viewHolder = new ViewHolderLista(convertView);
            convertView.setTag(viewHolder);
        }

        viewHolder.update(produtos.get(position));
        return convertView;
    }

    private class ViewHolderLista {
        private TextView tvNome, tvDescricao, tvPreco;
        private ImageView imgProduto;

        public ViewHolderLista(View view) {
            tvNome = view.findViewById(R.id.tvNome);
            tvDescricao = view.findViewById(R.id.tvDescricao);
            tvPreco = view.findViewById(R.id.tvPreco);
            imgProduto = view.findViewById(R.id.imgProduto);
        }

        // Atualiza os dados da linha
        public void update(Produto produto) {
            tvNome.setText(produto.getNome());
            tvDescricao.setText(produto.getDescricao());
            tvPreco.setText(String.format("€ %.2f", produto.getPreco()));

            // Carregar imagem com Glide (se aplicável)
            Glide.with(context)
                    .load("URL_DA_IMAGEM_AQUI") // Substituir com o URL real
                    .placeholder(R.drawable.placeholder) // Imagem de placeholder
                    .diskCacheStrategy(DiskCacheStrategy.ALL)
                    .into(imgProduto);
        }
    }
}
