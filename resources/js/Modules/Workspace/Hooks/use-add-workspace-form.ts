import { useForm } from "@inertiajs/react";
import { CreateWorkspaceFormData } from "../Types/CreateWorkspaceFormData";

export function useAddWorkspace() {
    const { data, setData, post, processing, errors, reset } = useForm<CreateWorkspaceFormData>({
        name: '',
    });

    const submit = (e: React.FormEvent) => {
        e.preventDefault();
        post("/workspaces", {
            onSuccess: () => reset(),
            onError: () => {
                console.log(errors);
            }
        });
        
    };

    return { data, setData, submit, processing, errors };
}
