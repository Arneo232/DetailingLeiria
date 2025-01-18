package com.example.amsi.adaptadores;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.Button;
import android.widget.ImageView;
import android.widget.TextView;

import com.bumptech.glide.Glide;
import com.bumptech.glide.load.engine.DiskCacheStrategy;
import com.example.amsi.R;
import com.example.amsi.modelo.Favorito;
import com.example.amsi.modelo.SingletonGestorProdutos;

import java.util.ArrayList;

public class ListaFavoritosAdaptador extends BaseAdapter {
    private Context context;
    private LayoutInflater inflater;
    private ArrayList<Favorito> favorito;

    public ListaFavoritosAdaptador(Context context, ArrayList<Favorito> favorito) {
        this.context = context;
        this.favorito = favorito;
    }

    @Override
    public int getCount() {
        return favorito.size();
    }

    @Override
    public Object getItem(int i) {
        return favorito.get(i);
    }

    @Override
    public long getItemId(int i) {
        return favorito.get(i).getIdproduto();
    }

    @Override
    public View getView(int position, View view, ViewGroup viewGroup) {
        if (inflater == null) {
            inflater = (LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
        }
        if (view == null) {
            view = inflater.inflate(R.layout.item_lista_favorito, null);
        }
        ViewHolderLista viewHolder = (ViewHolderLista) view.getTag();
        if (viewHolder == null) {
            viewHolder = new ViewHolderLista(view);
            view.setTag(viewHolder);
        }

        viewHolder.update(favorito.get(position), position);
        return view;
    }

    private class ViewHolderLista {
        private TextView tvNome, tvPreco;
        private ImageView imgProduto;
        private Button btnRemoverFav;

        public ViewHolderLista(View view) {
            tvNome = view.findViewById(R.id.tvNome);
            tvPreco = view.findViewById(R.id.tvPreco);
            imgProduto = view.findViewById(R.id.imgProduto);
            btnRemoverFav = view.findViewById(R.id.btnRemoverFav);
        }

        public void update(Favorito favorito, int position) {
            tvNome.setText(favorito.getNome());
            tvPreco.setText(favorito.getPreco() + "");
            Glide.with(context)
                    .load(favorito.getImagem())
                    .placeholder(R.drawable.dl_logo)
                    .diskCacheStrategy(DiskCacheStrategy.ALL)
                    .into(imgProduto);

            btnRemoverFav.setOnClickListener(v -> {
                SingletonGestorProdutos.getInstance(context).deleteFavoritoAPI(context, favorito.getIdfavorito());
                ListaFavoritosAdaptador.this.favorito.remove(position);
                notifyDataSetChanged();
            });
        }
    }
}
