import type { PageProps } from '@inertiajs/core';
import type { LucideIcon } from 'lucide-vue-next';
import type { Config } from 'ziggy-js';

export interface Auth {
    user: User;
}

export interface BreadcrumbItem {
    title: string;
    href: string;
}

export interface NavItem {
    title: string;
    href: string;
    icon?: LucideIcon;
    isActive?: boolean;
}

export interface SharedData extends PageProps {
    name: string;
    quote: { message: string; author: string };
    auth: Auth;
    ziggy: Config & { location: string };
    sidebarOpen: boolean;
}

export interface User {
    id: number;
    name: string;
    email: string;
    avatar?: string;
    email_verified_at: string | null;
    created_at: string;
    updated_at: string;
}

export type BreadcrumbItemType = BreadcrumbItem;

export interface Participante {
  id: number;
  nombres: string;
  apellidos: string;
  dni: string;
  departamento: string;
  provincia: string;
  distrito: string;
  direccion_actual: string;
  tipo_participante: 'individual' | 'corporativo';
  codigo_pago: string;
  foto_voucher: string | null;
  comprobante: 'boleta' | 'factura';
  numero_ruc: string | null;
  nombre_corporativo: string | null;
  estado: boolean;
  created_at: string;
  updated_at: string;
}
