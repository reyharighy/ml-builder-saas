import { NavItem } from "@/types";
import { LayoutGrid, NotebookText, Table2 } from "lucide-vue-next";

export const mainNavItems: NavItem[] = [
    {
        title: 'Dashboard',
        href: route('dashboard'),
        icon: LayoutGrid,
    },
    {
        title: 'Datasets',
        href: route('datasets.index'),
        icon: Table2,
    },
    {
        title: 'Project Hub',
        href: route('projects.index'),
        icon: NotebookText,
    },
];
