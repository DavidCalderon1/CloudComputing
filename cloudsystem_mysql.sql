
create table proveedor
(
	IdProveedor int not null,
	Nom_Proveedor varchar(80) not null,
	Dir_Proveedor varchar(100) not null,	
	Tel_Proveedor varchar(15) not null,
	primary key (IdProveedor)
);


create table producto
(
	IdProducto int not null,
	Nom_Producto varchar(60) not null,
	Desc_Producto varchar(100) not null,
	Producto_IdProveedor int not null,
	primary key (IdProducto),
	constraint FK_producto_proveedor foreign key (Producto_IdProveedor) references proveedor(IdProveedor)
); 

create table pedido
(
	IdPedido int not null,
	Fecha_Pedido datetime not null,
	Pedidos_IdProducto int not null,
	Cantidad_Pedido int not null,
	Valor_Pedido int not null,
	primary key (IdPedido),
	constraint FK_pedido_producto foreign key (Pedidos_IdProducto) references producto(IdProducto)
);

create table cliente
(
	IdCliente int not null primary key,
	Nom_Cliente varchar(80) not null,
	Dir_Cliente varchar(80) null,
	Tel_Cliente numeric null
);
insert into cliente values (1,'Pepito Perez','Calle 1 # 20-30 sur','3111111');
CREATE TABLE tipo_usuario (
  IdTipo_Usuario int NOT NULL,
  Nom_Tipo_Usuario varchar(30) DEFAULT NULL,
  PRIMARY KEY (IdTipo_Usuario)
);

--
-- Datos para la tabla tipo_usuario
--

INSERT INTO tipo_usuario (IdTipo_Usuario, Nom_Tipo_Usuario) VALUES
(1, 'SOPORTE'),
(2, 'ADMINISTRADOR'),
(3, 'COLABORADOR'),
(4, 'CLIENTE'),
(5, 'AUDITOR');

CREATE TABLE usuario (
  IdUsuario int NOT NULL,
  Usuario_Nombre varchar(30) DEFAULT NULL,
  Usuario_Password varchar(50) DEFAULT NULL,
  Usuario_IdTipo_Usuario int NOT NULL,
  Rol_Usuario char(3) DEFAULT NULL,
  Estado_Usuario char(3) DEFAULT NULL,
  PRIMARY KEY (IdUsuario),
  constraint FK_usuario_tipo_usuario foreign key (Usuario_IdTipo_Usuario) references tipo_usuario(IdTipo_Usuario)
);

--
--  Datos para la tabla usuario
--
INSERT INTO usuario (IdUsuario, Usuario_Nombre, Usuario_Password, Usuario_IdTipo_Usuario, Rol_Usuario, Estado_Usuario) VALUES
(1, 'Soporte', '6b57ac5c1f68820922977eb752099641', 1, NULL, 1),
(2, 'Admin', '4831aa574a686c8afd1b5c24f574f981', 5, NULL, 1);


create table factura
(
	IdFactura int not null,
	Fecha_Factura datetime not null,
	Factura_IdUsuario int not null,
	Factura_IdCliente int not null,
	Valor_Total numeric not null,
	Valor_Pagar numeric not null,
	PRIMARY KEY (IdFactura),
	constraint FK_factura_usuario foreign key (Factura_IdUsuario) references usuario(IdUsuario),
	constraint FK_factura_cliente foreign key (Factura_IdCliente) references cliente(IdCliente)	
);

create table producto_factura
(
	IdProd_Factura int not null,
	Prod_Factura_IdProducto int not null,
	Prod_Factura_IdFactura int not null,
	Prod_Fact_Cantidad numeric not null,
	Valor_Unitario numeric not null,
	Valor_Total numeric not null,
	primary key (IdProd_Factura),
	constraint FK_prod_factura_producto foreign key (Prod_Factura_IdProducto) references producto(IdProducto),
	constraint FK_prod_factura_factura foreign key (Prod_Factura_IdFactura) references factura(IdFactura)
);