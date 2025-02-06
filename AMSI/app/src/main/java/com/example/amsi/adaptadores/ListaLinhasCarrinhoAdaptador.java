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
import com.example.amsi.modelo.LinhasCarrinho;
import com.example.amsi.modelo.SingletonGestorProdutos;

import java.util.ArrayList;

public class ListaLinhasCarrinhoAdaptador extends BaseAdapter {
    private Context context;
    private LayoutInflater inflater;
    private ArrayList<LinhasCarrinho> linhasCarrinhoList;

    public ListaLinhasCarrinhoAdaptador(Context context, ArrayList<LinhasCarrinho> linhasCarrinhoList) {
        this.context = context;
        this.linhasCarrinhoList = linhasCarrinhoList;
    }

    @Override
    public int getCount() {
        return linhasCarrinhoList.size();
    }

    @Override
    public Object getItem(int position) {
        return linhasCarrinhoList.get(position);
    }

    @Override
    public long getItemId(int position) {
        return linhasCarrinhoList.get(position).getIdLinhaCarrinho();
    }

    @Override
    public View getView(final int position, View convertView, ViewGroup parent) {
        if (inflater == null) {
            inflater = (LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
        }

        if (convertView == null) {
            convertView = inflater.inflate(R.layout.item_linha_carrinho, null);
        }

        ViewHolder viewHolder = (ViewHolder) convertView.getTag();
        if (viewHolder == null) {
            viewHolder = new ViewHolder(convertView);
            convertView.setTag(viewHolder);
        }

        viewHolder.update(linhasCarrinhoList.get(position), position);

        return convertView;
    }

    private class ViewHolder {
        private TextView tvNomeProduto, tvPrecoUnitario, tvQuantidade, tvSubtotal;
        private ImageView imgProduto;
        private Button btnRemoverCarrinho, btnAumentarQuantidade, btnDiminuirQuantidade;

        public ViewHolder(View view) {
            tvNomeProduto = view.findViewById(R.id.tvNomeProduto);
            tvPrecoUnitario = view.findViewById(R.id.tvPrecoUnitario);
            tvQuantidade = view.findViewById(R.id.tvQuantidade);
            tvSubtotal = view.findViewById(R.id.tvSubtotal);
            imgProduto = view.findViewById(R.id.imgLinha);
            btnRemoverCarrinho = view.findViewById(R.id.btnRemoverCarrinho);
            btnAumentarQuantidade = view.findViewById(R.id.btnAumentarQuantidade);
            btnDiminuirQuantidade = view.findViewById(R.id.btnDiminuirQuantidade);
        }

        public void update(final LinhasCarrinho linhaCarrinho, final int position) {
            tvNomeProduto.setText(linhaCarrinho.getNomeProduto());
            tvPrecoUnitario.setText(String.format("€%.2f", linhaCarrinho.getPrecounitario()));
            tvQuantidade.setText(String.valueOf(linhaCarrinho.getQuantidade()));
            tvSubtotal.setText(String.format("€%.2f", linhaCarrinho.getSubtotal()));

            Glide.with(context)
                    .load(linhaCarrinho.getImagem())
                    .placeholder(R.drawable.dl_logo)
                    .diskCacheStrategy(DiskCacheStrategy.ALL)
                    .into(imgProduto);

            btnRemoverCarrinho.setOnClickListener(v -> {
                SingletonGestorProdutos.getInstance(context).removerLinhaCarrinhoAPI(context, linhaCarrinho.getIdLinhaCarrinho());
                linhasCarrinhoList.remove(position);
                notifyDataSetChanged();
            });

            btnAumentarQuantidade.setOnClickListener(v -> {
                SingletonGestorProdutos.getInstance(context).aumentarQuantidadeAPI(context, linhaCarrinho.getIdLinhaCarrinho());

                linhaCarrinho.setQuantidade(linhaCarrinho.getQuantidade() + 1);
                linhaCarrinho.setSubtotal(linhaCarrinho.getQuantidade() * linhaCarrinho.getPrecounitario());
                notifyDataSetChanged();
            });

            btnDiminuirQuantidade.setOnClickListener(v -> {
                SingletonGestorProdutos.getInstance(context).diminuirQuantidadeAPI(context, linhaCarrinho.getIdLinhaCarrinho());

                linhaCarrinho.setQuantidade(linhaCarrinho.getQuantidade() - 1);
                linhaCarrinho.setSubtotal(linhaCarrinho.getQuantidade() * linhaCarrinho.getPrecounitario());
                notifyDataSetChanged();
            });
        }
    }
}