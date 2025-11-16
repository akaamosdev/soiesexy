<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Nouvelle commande #{{ $order->code }}</title>
</head>
<body>
<h2>Nouvelle commande reçue — #{{ $order->code }}</h2>

<p><strong>Date :</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>

<h3>Informations client</h3>
<p>
    Nom : {{ $order->address->name }} <br>
    Téléphone : {{ $order->address->phone }} <br>
    Adresse : {{ $order->address->address }} <br>
</p>

<h3>Détails de la commande</h3>
<ul>
    @foreach($order->items as $item)
        <li>{{ $item->product->name }} — Taille: {{ $item->taille->name  }} —
            Colors : {{ $item->color->name  }}
            — Qty: {{ $item->quantity }} —
            {{ number_format($item->price, 2) }}
        </li>
    @endforeach
</ul>

<p><strong>Livraison :</strong> {{ number_format($order->address->frais,2) }}</p>
<p><strong>Total :</strong> {{ number_format($order->montant,2) }}</p>

<hr>
<p>Envoyé automatiquement depuis Soie Sexy</p>
</body>
</html>
