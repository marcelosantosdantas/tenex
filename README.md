# Instruções para Configuração e Teste da API de Carnês

## 1. Inicialização do Docker e Instalação do Ambiente

Para iniciar o Docker e instalar todo o ambiente, execute o comando abaixo:

```bash
docker-compose up -d
```

### Observações:
- A instalação e configuração do Laravel Lumen podem levar de 3 a 5 minutos, dependendo da velocidade da sua internet. Durante esse processo, todas as dependências serão instaladas e o ambiente será configurado automaticamente.

## 2. Acesso ao Swagger para Testes

Após a inicialização do sistema, você pode acessar a documentação do Swagger para testar a API diretamente no navegador:

Swagger UI - Documentação da API: http://localhost:8000/docs

## 3. Banco de Dados

Estamos utilizando o PostgreSQL para armazenar os carnês criados, permitindo que você realize consultas posteriormente.

### Configurações de Conexão:
Para acessar o banco de dados via DBeaver, pgAdmin, ou outro cliente de banco de dados, utilize as seguintes credenciais:

```bash
DB_CONNECTION=pgsql
DB_HOST=db
DB_PORT=5432
DB_DATABASE=carne
DB_USERNAME=carne_user
DB_PASSWORD=secret
```
## 4. Testes via Postman

Você pode testar as funcionalidades da API utilizando o Postman ou diretamente via cURL.

### 4.1. Criar Carnê

Requisição:
```bash
curl -X POST http://localhost:8000/carne \
-H "Content-Type: application/json" \
-d '{
  "valor_total": 100.00,
  "qtd_parcelas": 12,
  "data_primeiro_vencimento": "2024-09-01",
  "periodicidade": "mensal",
  "valor_entrada": 10.00
}'
```
### 4.2. Consultar Parcelas

Para consultar as parcelas de um carnê específico, substitua 1 pelo ID do carnê desejado:

Requisição:
```bash
curl -X GET http://localhost:8000/carne/1/parcelas
```
