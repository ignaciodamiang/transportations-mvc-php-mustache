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
primary key (id),
foreign key(id_tipoUsuario) references TipoUsuario(id)
);

create table TipoVehiculo(
id int auto_increment,
tipo_vehiculo varchar(50),
primary key(id)
);

create table Vehiculo(
id int auto_increment,
patente varchar(20),
numero_chasis int,
numero_motor int,
marca varchar(50),
modelo varchar(50),
año_Fabricacion int,
kilometraje int,
estado varchar(50),
alarma varchar(50),
id_tipoVehiculo int,
primary key (id),
foreign key (id_tipoVehiculo) references TipoVehiculo(id)
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
fecha_inicio varchar(50),
hora_inicio varchar(50),
fecha_fin varchar(50),
hora_fin varchar(50),
tiempo_estimado varchar(50),
tiempo_real varchar(50),
tipo_carga varchar(50),
km_previsto double,
km_reales double,
desviacion double,
posicion_gps varchar(50),
combustible_estimado double, 
combustible_real double,
id_vehiculo int,
id_usuario int,
primary key(id),
foreign key(id_vehiculo) references Vehiculo(id),
foreign key(id_usuario) references Usuario(id)
);

insert into TipoUsuario(id, rol)
values(1, "administrador"), (2, "gerente"), (3, "chofer"), (4, "mecanico");

insert into Usuario(id, nombre, apellido, legajo, dni, fecha_nacimiento, id_tipoUsuario, email, contraseña)
values(1, "pepe", "argento", 1, 42225, "01-01-1999", 1, "pepeargento@gmail.com", "1234");
