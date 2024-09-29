import { useForm } from "@inertiajs/react";
import { CreateFolderFormData } from "../Types/CreateFolderFormData";

export function useAddFolder() {
    const { data, setData, post, processing, errors, reset } = useForm<CreateFolderFormData>({
        name: '',
    });

    const submit = (e: React.FormEvent) => {
        e.preventDefault();
        post("/folders", {
            onSuccess: () => reset(),
        });
        
    };

    return { data, setData, submit, processing, errors };
}
