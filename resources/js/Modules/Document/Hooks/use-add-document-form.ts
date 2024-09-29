import { useForm } from "@inertiajs/react";
import { CreateDocumentFormData } from "../Types/CreateDocumentFormData";

export function useAddDocument() {
    const { data, setData, post, processing, errors, reset } = useForm<CreateDocumentFormData>({
        name: '',
    });

    const submit = (e: React.FormEvent) => {
        e.preventDefault();
        post("/documents", {
            onSuccess: () => reset(),
        });
        
    };

    return { data, setData, submit, processing, errors };
}
