import { router } from "@inertiajs/react";

interface UseDocumentProperties {
    openDocument: (type?: string, id?: string) => void;
}

export function useDocumentProperties(): UseDocumentProperties {
    const openDocument = (type?: string, id?: string) => {
        if (type !== "document") {
            return;
        }
        router.visit(route("document.show", { document: id }));
    };

    return { openDocument };
}