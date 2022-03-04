@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#novaUrl">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus"
                    viewBox="0 0 16 16">
                    <path
                        d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
                </svg>
                Novo
            </button>
            <table class="table table-bordered lista">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">URL</th>
                        <th scope="col">Status Code</th>
                        <th scope="col">Ultima Atualização</th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($urls as $url)
                        <tr>
                            <th scope="row">{{ $url->id }}</th>
                            <td>{{ $url->url }}</td>
                            <td>{{ $url->status_code }}</td>
                            <td>{{ date('d/m/Y H:i:s', strtotime($url->updated_at)) }}</td>
                            <td>
                                <button type="button" onclick="exibirSite(event)" class="btn btn-success exibir-site" data-html="{{ $url->resposta }}"
                                    data-bs-toggle="modal" data-bs-target="#exibeConteudo">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-eye" viewBox="0 0 16 16">
                                        <path
                                            d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z" />
                                        <path
                                            d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z" />
                                    </svg>
                                </button>
                            </td>
                            <td>
                                <button type="button" onclick="preEditar(event)" class="btn btn-warning" data-url="{{$url->url}}" data-id="{{$url->id}}"
                                    data-bs-toggle="modal" data-bs-target="#editarUrl">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                    <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
                                    </svg>
                                </button>
                            </td>
                            <td>
                                <button type="button" onclick="excluir(event)" class="btn btn-danger" data-id="{{$url->id}}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-x" viewBox="0 0 16 16">
                                    <path d="M6.146 6.146a.5.5 0 0 1 .708 0L8 7.293l1.146-1.147a.5.5 0 1 1 .708.708L8.707 8l1.147 1.146a.5.5 0 0 1-.708.708L8 8.707 6.854 9.854a.5.5 0 0 1-.708-.708L7.293 8 6.146 6.854a.5.5 0 0 1 0-.708z"/>
                                    <path d="M4 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H4zm0 1h8a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1z"/>
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="novaUrl" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Nova URL</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('store') }}" onsubmit="novaUrl(event)">
                        @csrf
                        <div class="mb-3">
                            <label for="url" class="form-label">Url</label>
                            <input type="text" class="form-control" id="url" name="url" aria-describedby="emailHelp">
                        </div>
                        <button type="submit" class="btn btn-primary">Salvar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="editarUrl" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Editar URL</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('store') }}" onsubmit="editar(event)">
                        @csrf
                        <input type="hidden" name="id" id="editarid">
                        <div class="mb-3">
                            <label for="url" class="form-label">Url</label>
                            <input type="text" class="form-control" id="editarurl" name="url" aria-describedby="emailHelp">
                        </div>
                        <button type="submit" class="btn btn-primary">Salvar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exibeConteudo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <iframe id="conteudoHtml" width="100%" height="100%"></iframe>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>



    <script>
        function lista(){
            window.axios.get(window.location.origin + '/api/lista').then(response => {
                document.querySelector('.lista').getElementsByTagName('tbody')[0].innerHTML = ""
                response.data.forEach(function(item) {
                    appendtr(item)
                });
            })            
        }

       setInterval(() => {
            window.axios.get(window.location.origin + '/api/lista').then(response => {
                document.querySelector('.lista').getElementsByTagName('tbody')[0].innerHTML = ""
                response.data.forEach(function(item) {
                    appendtr(item)
                });
            })
        }, 60000);

        function validaURL(str) {
            var pattern = new RegExp('^(https?:\\/\\/)?'+ // protocol
            '((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|'+ // domain name
            '((\\d{1,3}\\.){3}\\d{1,3}))'+ // OR ip (v4) address
            '(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*'+ // port and path
            '(\\?[;&a-z\\d%_.~+=-]*)?'+ // query string
            '(\\#[-a-z\\d_]*)?$','i'); // fragment locator
            return !!pattern.test(str);
        }

        function exibirSite(e){
            let resposta = e.currentTarget.dataset.html
            let iframe = document.getElementById('conteudoHtml');
            iframe.contentWindow.document.open();
            iframe.contentWindow.document.write('');
            iframe.contentWindow.document.write(resposta);
        }

        function preEditar(e){
            let url = e.currentTarget.dataset.url
            let id = e.currentTarget.dataset.id
            let inputUrl = document.querySelector('#editarurl').value = url
            let inputId = document.querySelector('#editarid').value = id
        }

        function editar(e){
            e.preventDefault();
            let form = new FormData(e.target);
            let id = form.get('id')
            window.axios.post(window.location.origin + '/' + id, form).then(function(response) {
                    if(response.status == 200){
                        appendtr(response.data)
                        alert('Alterado Com Sucesso')
                        window.editarUrlModal.hide()
                        lista()
                    }
            })
        }

        function excluir(e){
            let id = e.currentTarget.dataset.id
            window.axios.delete(window.location.origin + '/' + id).then(function(response) {
                alert('Removido Com Sucesso')
                lista();
            })
        }

        function novaUrl(e) {
            e.preventDefault();
            //validaURL()
            let form = new FormData(e.target);
            if(validaURL(form.get('url'))){
                let url = e.currentTarget.getAttribute('action')
                window.axios.post(url, form).then(function(response) {
                    if(response.status == 201){
                        appendtr(response.data)
                        alert('Salvo Com Sucesso')
                        window.novaUrlModal.hide()
                    }
                    
                })
            }else{
                alert("URL Invalida");
            }
        }

        function appendtr(data) {
            let date = new Date(data.updated_at);
            let data_atualizacao = ("00" + (date.getMonth() + 1)).slice(-2) + "/" +
                ("00" + date.getDate()).slice(-2) + "/" +
                date.getFullYear() + " " +
                ("00" + date.getHours()).slice(-2) + ":" +
                ("00" + date.getMinutes()).slice(-2) + ":" +
                ("00" + date.getSeconds()).slice(-2);
            let tbody = document.querySelector('.lista').getElementsByTagName('tbody')[0];
            let row = tbody.insertRow();
            let cell1 = row.insertCell(0);
            let cell2 = row.insertCell(1);
            let cell3 = row.insertCell(2);
            let cell4 = row.insertCell(3);
            let cell5 = row.insertCell(4);
            let cell6 = row.insertCell(5);
            let cell7 = row.insertCell(6);
            cell1.outerHTML = `<th scope="row">${data.id}</th>`;
            cell2.innerHTML = data.url;
            cell3.innerHTML = data.status_code;
            cell4.innerHTML = data_atualizacao;
            cell5.innerHTML = `<button type="button" class="btn btn-success" onclick="exibirSite(event)" data-bs-toggle="modal" data-bs-target="#exibeConteudo">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                    <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
                                    <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                                </svg>
                            </button>`
            cell6.innerHTML = `<button type="button" onclick="preEditar(event)" class="btn btn-warning""
                                    data-bs-toggle="modal" data-bs-target="#editarUrl">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                    <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
                                    </svg>
                                </button>`
            cell7.innerHTML = `<button type="button" onclick="excluir(event)" class="btn btn-danger">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-x" viewBox="0 0 16 16">
                                    <path d="M6.146 6.146a.5.5 0 0 1 .708 0L8 7.293l1.146-1.147a.5.5 0 1 1 .708.708L8.707 8l1.147 1.146a.5.5 0 0 1-.708.708L8 8.707 6.854 9.854a.5.5 0 0 1-.708-.708L7.293 8 6.146 6.854a.5.5 0 0 1 0-.708z"/>
                                    <path d="M4 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H4zm0 1h8a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1z"/>
                                    </svg>
                                </button>`
            cell5.childNodes[0].setAttribute('data-html', data.resposta)
            cell6.childNodes[0].setAttribute('data-url', data.url)
            cell6.childNodes[0].setAttribute('data-id', data.id)
            cell7.childNodes[0].setAttribute('data-id', data.id)
        }
    </script>
@endsection
