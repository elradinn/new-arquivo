import { Modal, Text, TextInput, Button, Stack, Flex } from "@mantine/core";
import { NumberingSchemeResourceData } from "../Types/NumberingSchemeResourceData";
import { useUpdateNumberingScheme } from "../Hooks/use-update-numbering-scheme";
import useModalStore from "@/Modules/Common/Hooks/use-modal-store";
import { ItemParentResourceData } from "@/Modules/Item/Types/ItemParentResourceData";

interface NumberingSchemeFormProps {
    initialData?: NumberingSchemeResourceData;
    itemParent: ItemParentResourceData;
}

const NumberingSchemeForm: React.FC<NumberingSchemeFormProps> = ({
    initialData,
    itemParent,
}) => {
    const { data, setData, handleSubmit, processing, errors } = useUpdateNumberingScheme({
        initialData,
        close,
    });

    const { modals, closeModal } = useModalStore();

    return (
        <Modal
            opened={modals["numberingScheme"]}
            onClose={() => closeModal("numberingScheme")}
            title={<Text size="lg">{initialData ? "Edit" : "Create"} Numbering Scheme</Text>}
            size={550}
        >
            <form onSubmit={handleSubmit}>
                <Stack gap={16}>
                    <TextInput
                        label="Name"
                        value={data.name}
                        onChange={(e) => setData("name", e.target.value)}
                        error={errors.name}
                    />
                    <TextInput
                        label="Prefix"
                        value={data.prefix}
                        onChange={(e) => setData("prefix", e.target.value)}
                        error={errors.prefix}
                    />
                </Stack>
                <Flex align="center" justify="end" mt={16}>
                    <Button variant="light" onClick={() => closeModal("numberingScheme")}>
                        Cancel
                    </Button>
                    <Button ml={12} type="submit" loading={processing}>
                        {initialData ? "Update" : "Create"}
                    </Button>
                </Flex>
            </form>
        </Modal>
    );
};

export default NumberingSchemeForm;