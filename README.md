#Comando para inciar o docker e isntalar todo o processo
docker-compose up -d

#Após a conclusão da instalação do docker dependendo da internete poderá demorar de 3 a 5 minutos para instalação e configuração do laravel lumem

#Quando o sistema estiver no ar o swagger deverá estar ativo para teste
http://localhost:8000/docs

#Estou utilizando o Postgre para armazenar ps cares criados para poder ser realizado as consultas


#Para teste via postman pode ser importado o curl para o postman
#CRIAR CARNE
curl -X POST http://localhost:8000/carne \
-H "Content-Type: application/json" \
-d '{
  "valor_total": 100.00,
  "qtd_parcelas": 12,
  "data_primeiro_vencimento": "2024-09-01",
  "periodicidade": "mensal",
  "valor_entrada": 10.00
}'


#Consulta das parcelas, para pesquisar um id em especifico mudar o numero 1 para o ID do carne registrado
curl -X GET http://localhost:8000/carne/1/parcelas


#Para ter acesso via DBEAVER ou admin de banco 
DB_CONNECTION=pgsql
DB_HOST=db
DB_PORT=5432
DB_DATABASE=carne
DB_USERNAME=carne_user
DB_PASSWORD=secret
