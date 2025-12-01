<style>

:root{
    --green:#13a74b;
    --green-dark:#0f8e3f;
    --soft-shadow:0 4px 10px rgba(0,0,0,.08);
    --hover-shadow:0 8px 20px rgba(0,0,0,.15);
}

/* ==========================
   🏷 Banner catálogos
========================== */
.catalog-banner{
    width: 100%;
    height: 320px;
    object-fit: cover;
    border-radius:12px;
}

.catalog-title{
    font-size: 2.7rem;
    font-weight: 900;
    color: white;
    text-shadow: 0px 3px 10px rgba(0,0,0,.5);
}


/* ==========================
   🧭 Sidebar Filtro
========================== */
.filter-box{
    background:rgba(255,255,255,0.65);
    backdrop-filter:blur(12px);
    padding: 22px;
    border-radius: 14px;
    box-shadow: var(--soft-shadow);
    position: sticky;
    top: 20px;
    transition:.25s;
}

.filter-box:hover{
    background:rgba(255,255,255,.95);
    transform:scale(1.01);
}


/* ==========================
   📦 Cards productos
========================== */
.moto-card {
    border-radius: 18px;
    transition: .3s ease;
    overflow: hidden;
    border: none;
    position: relative;
    background: white;
    box-shadow: var(--soft-shadow);
    cursor:pointer;
}

.moto-card:hover {
    transform: translateY(-6px);
    box-shadow: var(--hover-shadow);
}

.catalog-img{
    width: 100%;
    height: 240px;
    object-fit: contain;
    background: #fff;
    padding: 18px;
    transition: .3s ease;
}

.catalog-img:hover{
    transform:scale(1.06);
    filter:drop-shadow(0 4px 12px rgba(0,0,0,.15));
}


/* ==========================
   🏷 Etiquetas
========================== */
.badge-new {
    background: var(--green);
    color: #fff;
    padding: 6px 14px;
    font-weight: bold;
    border-radius: 20px;
    position: absolute;
    top: 12px;
    left: 12px;
    font-size:.85rem;
}

.badge-off {
    background: #ff3131;
    color: #fff;
    padding: 6px 14px;
    font-weight: bold;
    border-radius: 20px;
    position: absolute;
    top: 12px;
    right: 12px;
    font-size:.85rem;
}


/* ==========================
   💰 Precios
========================== */
.price {
    font-size: 1.5rem;
    font-weight: 800;
    color: var(--green);
}

.old-price{
    text-decoration:line-through;
    color:#8b8b8b;
    font-size:.9rem;
}


/* ==========================
   🛒 Botones
========================== */
.btn-style {
    background: var(--green);
    border: none;
    transition: .2s;
    font-weight: bold;
    color: white;
    width:100%;
    padding:11px;
    border-radius:10px;
}

.btn-style:hover {
    background: var(--green-dark);
    transform: scale(1.02);
}


/* ==========================
   📱 Responsive ajustes
========================== */

@media(max-width:768px){

    .catalog-banner{
        height:190px;
        border-radius:8px;
    }

    .catalog-title{
        font-size:1.9rem;
        text-align:center;
    }

    .filter-box{
        position:relative;
        margin-bottom:20px;
    }

    .catalog-img{
        height:190px;
    }
}

</style>
