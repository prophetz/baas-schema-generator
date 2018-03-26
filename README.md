# BAAS Schema Generator

> Данный текст будет заключен в HTML-теги

Generating schema.json for all tables in database:
`
php bin/console schema:generate mysql://root:@127.0.0.1:3306/databaseName --outputPath=./export
`

Generating schema.json for specific table:
`
php bin/console schema:generate mysql://root:@127.0.0.1:3306/databaseName --outputPath=./export --tableName=specificTable
`
