<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class financpessoas extends Model
{
    public $timestamps = false;
    protected $table = "financ_pessoas";
    protected $fillable = array('pessoas_id', 'endereco', 'numero', 'bairro', 'cep' , 'complemento', 'cidade', 'estado', 'bancos_id', 'empresas_clientes_cloud_id', 'empresas_id', 'codigo_contabil');
}

/*
At twenty years of age I'm still looking for a dream
A war's already waged for my destiny
But You've already won the battle
And You've got great plans for me
Though I can't always see

Cause I got a couple dents in my fender
Got a couple rips in my jeans
Try to fit the pieces together
But perfection is my enemy
On my own I'm so clumsy
But on Your shoulders I can see
I'm free to be me

When I was just a girl I thought I had it figured out
See my life would turn out right, and I'd make it here somehow
But things don't always come that easy
And sometimes I would doubt, oh...

Cause I got a couple dents in my fender
Got a couple rips in my jeans
Try to fit the pieces together
But perfection is my enemy
On my own I'm so clumsy
But on Your shoulders I can see
I'm free to be me
And you're free to be you

Sometimes I believe that I can do anything
Yet other times I think I've got nothing good to bring
But You look at my heart and You tell me
That I've got all You seek, oh
And it's easy to believe
Even though

Oh, I got a couple dents in my fender
Got a couple rips in my jeans
Try to fit the pieces together
But perfection is my enemy
On my own I'm so clumsy
But on Your shoulders I can see

I got a couple dents in my fender
Got a couple rips in my jeans
Try to fit the pieces together
But perfection is my enemy
On my own I'm so clumsy
But on Your shoulders I can see
I'm free to be me
And you're free to be you
*/