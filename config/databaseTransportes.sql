create database transporteslamatanza;
use transporteslamatanza;

create table TipoUsuario(
id int auto_increment,
rol varchar (50),
primary key(id)
);

create table Usuario(
id int auto_increment,
nombre varchar (50),
apellido varchar(50),
legajo int,
dni int,
fecha_nacimiento varchar(50),
tipo_licencia varchar(50),
id_tipoUsuario int,
email varchar(50),
contraseña varchar(50),
cuenta_activada boolean,
primary key (id),
foreign key(id_tipoUsuario) references TipoUsuario(id)
);

create table Arrastre(
id int auto_increment,
patente varchar(40),
numeroDeChasis int,
tipo varchar(50),
peso_Neto float not null,
hazard boolean not null,
reefer boolean not null,
temperatura DECIMAL(5,2),
primary key(id)
);

create table Vehiculo(
id int auto_increment,
patente varchar(20),
numero_chasis int,
numero_motor int,
marca varchar(50),
modelo varchar(50),
año_Fabricacion date,
kilometraje int,
estado varchar(50),
alarma varchar(50),
id_tipoVehiculo int,
primary key (id)
);

create table services(
id int auto_increment,
fecha varchar(50),
kilometros_unidad int,
costo double,
repuestos varchar(50),
id_vehiculo int,
id_usuario int,
primary key (id),
foreign key (id_vehiculo) references Vehiculo(id),
foreign key (id_usuario) references Usuario(id)
);

create table cliente(
    id int auto_increment,
    nombre varchar(50),
    apellido varchar(50), 
    primary key(id)
);
create table factura(
    id int auto_increment,
    fecha varchar(50),
    monto double,
    abonado boolean, 
    descripcion varchar(100),
    id_cliente int,
    primary key(id),
    foreign key(id_cliente) references Cliente(id)
);

create table Viaje(
id int auto_increment,
ciudad_origen varchar(50),
ciudad_destino varchar(50),
fecha_inicioReal date,
fecha_finReal date,
hora_inicio time,
hora_fin time,
tiempo_real varchar(50),
km_reales double,
desviacion double,
precioViaticos_Real double,
peajes_Real double, 
combustible_real double,
precioCombustible_real double,
precioExtras_real int,
precioTotal_real double,
id_cliente int,
id_vehiculo int,
id_arrastre int,
id_usuario int,
primary key(id),
foreign key(id_cliente) references Cliente(id),
foreign key(id_vehiculo) references Vehiculo(id),
foreign key(id_arrastre) references Arrastre(id),
foreign key(id_usuario) references Usuario(id)
);

create table Proforma(
id int auto_increment,
fecha_inicioEstimada date,
fecha_finEstimada date,
tiempo_estimado varchar(50),
km_previsto double,
combustible_previsto double,
precioViaticos_estimado double,
precioPeajes_estimado double,
precioCombustible_estimado double,
precioExtras_estimado double,
precioFee_estimado double,
precioHazard_estimado double,
precioReefer_estimado double,
precioTotal_estimado double,
id_cliente int,
id_vehiculo int,
id_arrastre int,
id_usuario int,
id_viaje int,
primary key(id),
foreign key(id_cliente) references Cliente(id),
foreign key(id_vehiculo) references Vehiculo(id),
foreign key(id_arrastre) references Arrastre(id),
foreign key(id_usuario) references Usuario(id),
foreign key(id_viaje) references Viaje(id)
);

create table ProformaChofer(
id_notificacion int not null auto_increment,
fecha_Inicio date,
latitud_actual varchar(50),
longitud_actual varchar(50),
combustible_actual double,
precioCombustible_actual double,
km_actuales double,
desviacion_actual double,
precioViaticos_actual double,
precioPeajes_actual double,
precioExtras_actual double,
id_viaje int,
primary key(id_notificacion),
foreign key(id_viaje) references Viaje(id)
);

insert into TipoUsuario(id, rol)
values(1, "administrador"), (2, "gerente"), (3, "chofer"), (4, "mecanico");

insert into Usuario(id, nombre, apellido, legajo, dni, fecha_nacimiento, tipo_licencia ,id_tipoUsuario, email, contraseña, cuenta_activada)
values(1, "admin", "admin", 1, 42225, "01-01-1999","A" , 1, "admin@gmail.com", "1234", true);

insert into Usuario(id, nombre, apellido, legajo, dni, fecha_nacimiento, tipo_licencia ,id_tipoUsuario, email, contraseña, cuenta_activada)
values(2, "gerente", "gerente", 2, 11222333, "01-01-1999","A" , 2, "gerente@gmail.com", "1234", true);

insert into Usuario(id, nombre, apellido, legajo, dni, fecha_nacimiento, tipo_licencia ,id_tipoUsuario, email, contraseña, cuenta_activada)
values(3, "chofer", "chofer", 2, 22333444, "01-01-1999","A" , 3, "chofer@gmail.com", "1234", true);

insert into Usuario(id, nombre, apellido, legajo, dni, fecha_nacimiento, tipo_licencia ,id_tipoUsuario, email, contraseña, cuenta_activada)
values(4, "mecanico", "mecanico", 2, 33444555, "01-01-1999","A" , 4, "mecanico@gmail.com", "1234", true);

/* usuarios sin rol*/

insert into Usuario(id, nombre, apellido, legajo, dni, fecha_nacimiento, email, contraseña, cuenta_activada)
values(9, "tomas", "lala", 2, 89878625, "05-02-1989","to@gmail.com", "1234", true),
		/*insert(3, "matias", "maradona", 3, 855578625, "05-02-1989","matiasmaradona@gmail.com", "1234"),
        (4, "ana", "poooo", 4, 89878625, "05-02-1989","tomaslala@gmail.com", "1234"),
        (5, "hola", "lk", 5, 89878625, "05-02-1989","tomaslala@gmail.com", "1234"),*/
        (6, "taza", "jjj", 6, 89878625, "05-02-1989","tom@gmail.com", "1234", true),
        (7, "equipo", "iiii", 7, 89878625, "05-02-1989","t@gmail.com", "1234", true),
        (8, "ventana", "tttt", 8, 89878625, "05-02-1989","tomasla@gmail.com", "1234", true);
        
insert into Usuario(id, nombre, apellido, legajo, dni, fecha_nacimiento, tipo_licencia ,id_tipoUsuario, email, contraseña, cuenta_activada)
values(5, "cho2", "chofer2", 4, 44, "01-01-1999","A" , 3, "chofer2@gmail.com", "1234", true);
 
select * from Viaje;
select * from Usuario WHERE id_tipoUsuario = '3';
select * from Usuario;
