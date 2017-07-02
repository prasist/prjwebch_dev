<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use App\Exceptions\CustomException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
            if ($e instanceof \Exception)
             {
                    // emails.exception is the template of your email
                    // it will have access to the $error that we are passing below
                     try {

                            if ($e->getCode()!=0) {

                                $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

                                \Mail::send('emails.logerros', ['msg_erros' => $e->getCode() . ' - ' . $e->getMessage() . ' - ' . $actual_link], function($message)
                                {
                                    $message->from('contato@sigma3sistemas.com.br', 'Sigma3');
                                    $message->subject('Log de Erros');
                                    $message->to('suporte@sigma3sistemas.com.br');
                                });

                            }


                     } catch (Exception $exc) {
                            dd($exc);
                     }

            }

        return parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {

        //Tratamento de erros para PDOException

          if($e->getCode())
          {

                if ($e->getCode()==23503)
                {
                     $sMensagem =   "Opa, não se preocupe!!! Não é erro, apenas um aviso que não é possivel excluir esse registro, pois ele possui referência(s) em outra(s) tabela(s). Para garantir a integridade dos dados, o sistema verifica se na tentativa da exclusão do registro não há vinculos com outros. Nesse caso é necessário primeiro excluir os registros vinculados antes de excluir o registro principal. Estamos recebendo um email com essa mensagem, em breve lhe retornaremos para auxiliá-lo(a).";
                }
                else
                {
                    $sMensagem = "Misericórdia... Ocorreu um erro. Lembre-se : 'Irai-vos mas não pequeis'. Estamos recebendo um email com o erro, em breve será resolvido.";
                }

                return view('errors.msgerro')
                ->with('erro',
                    [
                        'titulo' => 'Aviso',
                        'codigo'=> $e->getCode(),
                        'mensagem'=> $sMensagem,
                        'mensagem_original'=> $e->getMessage()
                    ]);
          }

          //Tratamento para página não encontrada
          if ($e instanceof NotFoundHttpException)
          {
             return redirect()->to('errors.404');
          }

           //outro tipo de erro não tratado
            return parent::render($request, $e);
    }
}
